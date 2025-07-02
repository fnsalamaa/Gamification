<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Story;
use App\Models\StudentAnswer;
use App\Models\Question;
use App\Models\Student;
use App\Traits\ChecksBadgeUnlock;

class StudentController extends Controller
{
    use ChecksBadgeUnlock;

    public function index()
    {
        $user = Auth::user();

        // Ambil student langsung dari kolom total_score
        $student = Student::where('user_id', $user->id)->firstOrFail();

        // 🔓 Cek dan unlock badge di sini
        $this->checkAndUnlockBadges($student);

        $selectedAvatar = $student->avatars()->wherePivot('is_selected', true)->first();
        $ownedBadges = $student->badges;
        $stories = Story::take(4)->get();
        $unlockedAvatars = $student->avatars()->wherePivot('is_unlocked', true)->get();

        // Ambil global leaderboard dari kolom total_score (bukan hitung ulang)
        $globalStudents = Student::with('user', 'selectedAvatarModel')
            ->orderByDesc('total_score')
            ->get();

        return view('student.dashboard', compact(
            'student',
            'selectedAvatar',
            'ownedBadges',
            'stories',
            'unlockedAvatars',
            'user',
            'globalStudents'
        ));
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'avatar_id' => 'nullable|exists:avatars,id',
        ]);

        // Update nama user
        $user->name = $request->name;
        $user->save();

        // Update kelas student
        $student->class = $request->class;
        $student->save();

        // Update avatar jika dipilih dan unlocked
        if ($request->avatar_id) {
            $avatar = $student->avatars()
                ->where('avatars.id', $request->avatar_id)
                ->wherePivot('is_unlocked', true)
                ->first();

            if ($avatar) {
                // Unselect semua avatar
                $student->avatars()->updateExistingPivot(
                    $student->avatars->pluck('id')->toArray(),
                    ['is_selected' => false]
                );

                // Pilih avatar yang baru
                $student->avatars()->updateExistingPivot($avatar->id, ['is_selected' => true]);
            }
        }

        return redirect()->route('student.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function submitAnswer(Request $request, Question $question)
    {
        $student = auth()->user()->student;
        if (!$student) {
            return back()->with('error', 'Data student tidak ditemukan.');
        }
        $studentId = $student->id;

        // Cek attempt sebelumnya
        $attempt = StudentAnswer::where('student_id', $studentId)
            ->where('question_id', $question->id)
            ->count();

        // Cek apakah sudah mencoba 3 kali
        if ($attempt >= 3) {
            // Redirect langsung ke soal berikutnya
            $story = $question->stage->story;
            return redirect()->route('student.story.readStory', [
                'story' => $story->id,
                'stage' => request('stage'),
                'question' => request('question') + 1
            ])->with('error', '❌ Kamu sudah mencoba 3 kali. Lanjut ke soal berikutnya!');
        }


        $selected = $request->selected_option;
        $isCorrect = $selected === $question->correct_answer;

        $score = 0;
        if ($isCorrect) {
            $score = match ($attempt) {
                0 => 5,
                1 => 3,
                2 => 1,
                default => 0,
            };
        }

        StudentAnswer::create([
            'student_id' => $studentId,
            'question_id' => $question->id,
            'attempt' => $attempt + 1,
            'selected_option' => $selected,
            'is_correct' => $isCorrect,
            'score_earned' => $score,
        ]);

        // 🔄 Update kolom total_score dari semua jawaban
        $totalScore = StudentAnswer::where('student_id', $studentId)->sum('score_earned');
        Student::where('id', $studentId)->update(['total_score' => $totalScore]);

        $msg = '';

        if ($isCorrect) {
            $msg = "🎉 Yay! Your answer is correct. Let's move on to the next question! Point: $score";
        } else {
            if ($attempt >= 2) {
                $msg = '❌ Incorrect and tried 3 times. Points not awarded.!';
            } else {
                $msg = "❌ Wrong answer. (Trial " . ($attempt + 1) . ")";
            }
        }
        return back()->with($isCorrect ? 'success' : 'error', $msg);

    }

}