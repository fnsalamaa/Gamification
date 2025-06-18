<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Avatar;
use App\Models\Story;
use Illuminate\Support\Facades\DB;

class StudentAvatarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')->with('error', 'Student not found.');
        }

        $folkloreCompleted = $student->completed_folklore ?? 0;

        $avatars = Avatar::all();

        foreach ($avatars as $avatar) {
            $studentAvatar = $student->avatars()->where('avatars.id', $avatar->id)->first();

            if (!$studentAvatar) {
                $student->avatars()->attach($avatar->id, [
                    'is_unlocked' => false,
                    'is_selected' => false,
                ]);
                $studentAvatar = $student->avatars()->where('avatars.id', $avatar->id)->first();
            }

            // Cek apakah unlock_condition berupa angka atau string
            if (is_numeric($avatar->unlock_condition)) {
                $avatar->is_unlocked = ($folkloreCompleted >= $avatar->unlock_condition)
                    || ($studentAvatar && $studentAvatar->pivot->is_unlocked);
            } else {
                $avatar->is_unlocked = $this->checkStoryRankCondition($student, $avatar->unlock_condition)
                    || ($studentAvatar && $studentAvatar->pivot->is_unlocked);
            }

            // Update pivot jika baru saja di-unlock
            if ($avatar->is_unlocked && !$studentAvatar->pivot->is_unlocked) {
                $student->avatars()->updateExistingPivot($avatar->id, [
                    'is_unlocked' => true,
                    'unlocked_at' => now(),
                ]);
            }

            // Tandai apakah avatar ini sedang dipilih
            $avatar->is_selected = $studentAvatar->pivot->is_selected;
        }

        return view('student.avatar.choose-avatar', compact('avatars', 'student'));
    }

    public function select($avatarId)
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $avatar = $student->avatars()
            ->where('avatars.id', $avatarId)
            ->wherePivot('is_unlocked', true)
            ->first();

        if (!$avatar) {
            return redirect()->back()->with('error', 'Avatar belum tersedia atau belum dibuka.');
        }

        $student->avatars()->updateExistingPivot(
            $student->avatars->pluck('id')->toArray(),
            ['is_selected' => false]
        );

        $student->avatars()->updateExistingPivot($avatarId, [
            'is_selected' => true,
        ]);

        return redirect()->route('student.avatar.choose')->with('success', 'Avatar berhasil dipilih!');
    }

    protected function checkStoryRankCondition($student, $condition)
    {
        $match = null;
        if (preg_match('/story_(.+)_1/', $condition, $match)) {
            $slug = str_replace('_', ' ', $match[1]);

            // Ambil story berdasarkan slug judul (case insensitive)
            $storyId = Story::whereRaw('LOWER(title) = ?', [strtolower($slug)])->value('id');
            if (!$storyId) return false;

            // Cek student top skor di story tersebut
            $topStudent = DB::table('student_answers')
                ->join('questions', 'student_answers.question_id', '=', 'questions.id')
                ->join('stages', 'questions.stage_id', '=', 'stages.id')
                ->where('stages.story_id', $storyId)
                ->select('student_answers.student_id', DB::raw('SUM(score_earned) as total_score'))
                ->groupBy('student_answers.student_id')
                ->orderByDesc('total_score')
                ->limit(1)
                ->first();

            return $topStudent && $topStudent->student_id === $student->id;
        }

        return false;
    }
}
