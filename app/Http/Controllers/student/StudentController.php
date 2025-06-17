<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Story;
use App\Models\StudentAnswer;
use App\Models\Question;
class StudentController extends Controller
{


    public function index()
    {
        $user = Auth::user(); // ⬅️ ambil user yang login
        $student = $user->student;
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('student.dashboard')->with('error', 'Student not found.');
        }

        // Ambil avatar yang dipilih (is_selected = true)
        $selectedAvatar = $student->avatars()->wherePivot('is_selected', true)->first();
        $ownedBadges = $student->badges; // relasi yang sudah kamu punya
        $stories = Story::take(4)->get();
        // Ambil semua avatar yang sudah di-unlock oleh student dari pivot table
        $unlockedAvatars = $student->avatars()->wherePivot('is_unlocked', true)->get();

        return view('student.dashboard', compact('student', 'selectedAvatar', 'ownedBadges', 'stories', 'unlockedAvatars', 'user'));
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

        if ($attempt >= 3) {
            // Redirect ke soal berikutnya
            return redirect()->route('student.play', [
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