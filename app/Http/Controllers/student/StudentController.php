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
        $newBadges = $this->checkAndUnlockBadges($student);
        if (!empty($newBadges)) {
            session()->flash('new_badges', $newBadges);
        }


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
    $stageIndex = (int) $request->stage;
    $questionIndex = (int) $request->question;
    $selected = $request->selected_option;

    // Hitung attempt sekarang
    $attempt = StudentAnswer::where('student_id', $studentId)
        ->where('question_id', $question->id)
        ->count();

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

    // Simpan jawaban
    StudentAnswer::create([
        'student_id' => $studentId,
        'question_id' => $question->id,
        'attempt' => $attempt + 1,
        'selected_option' => $selected,
        'is_correct' => $isCorrect,
        'score_earned' => $score,
    ]);

    // Update total skor student
    $totalScore = StudentAnswer::where('student_id', $studentId)->sum('score_earned');
    Student::where('id', $studentId)->update(['total_score' => $totalScore]);

    // Cek dan unlock badge
    $this->checkAndUnlockBadges($student);

    // Ambil semua question dari stage ini
    $currentStage = $question->stage;
    $questionsInStage = $currentStage->questions;
    $totalQuestions = $questionsInStage->count();
    $isLastQuestionInStage = $questionIndex + 1 >= $totalQuestions;

    // Cek apakah semua soal stage ini sudah benar atau dicoba 3x
    $allAnsweredOrMaxAttempt = $questionsInStage->every(function ($q) use ($studentId) {
        $jawaban = StudentAnswer::where('student_id', $studentId)
            ->where('question_id', $q->id)
            ->orderByDesc('created_at')
            ->first();

        return $jawaban && ($jawaban->is_correct || $jawaban->attempt >= 3);
    });

    // Ambil semua stage dari story
    $story = $currentStage->story;
    $allStages = $story->stages;
    $isLastStage = $stageIndex + 1 >= $allStages->count();

    // 🎯 Pesan feedback
    $msg = '';
    if ($isCorrect) {
        $msg = match ($attempt) {
            0 => "🎉 Great job! You got it right on the first try!\nYou’ve earned 5 points.",
            1 => "✅ Nice recovery! You got it right on the second try — 3 points!",
            default => "👍 You made it! Third time’s the charm — you’ve earned 1 point."
        };

        if (!$isLastQuestionInStage) {
            // 👉 Next question
            return redirect()->route('student.story.readStory', [
                'story' => $story->id,
                'stage' => $stageIndex,
                'question' => $questionIndex + 1,
            ])->with('success', $msg);
        } elseif (!$isLastStage && $allAnsweredOrMaxAttempt) {
            // 👉 Next stage
            return redirect()->route('student.story.readStory', [
                'story' => $story->id,
                'stage' => $stageIndex + 1,
                'question' => 0,
            ])->with('success', $msg);
        }
    } else {
        if ($attempt === 0) {
            $msg = "❌ Oops! Not quite right. You still have 2 more tries!";
        } elseif ($attempt === 1) {
            $msg = "❌ Almost there! One last try left!";
        } else {
            $msg = "❌ That’s okay, 3 chances used. 0 points this time. Let’s move on!";
            if (!$isLastQuestionInStage) {
                return redirect()->route('student.story.readStory', [
                    'story' => $story->id,
                    'stage' => $stageIndex,
                    'question' => $questionIndex + 1,
                ])->with('error', $msg);
            } elseif (!$isLastStage && $allAnsweredOrMaxAttempt) {
                return redirect()->route('student.story.readStory', [
                    'story' => $story->id,
                    'stage' => $stageIndex + 1,
                    'question' => 0,
                ])->with('error', $msg);
            }
        }
    }

    return back()->with($isCorrect ? 'success' : 'error', $msg);
}



}