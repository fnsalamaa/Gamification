<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Student;
use App\Models\StudentAnswer;
class LeaderboardController extends Controller
{
public function show(Story $story)
{
    // Ambil semua student beserta user dan avatars
    $students = Student::with(['user', 'avatars'])->get()
        ->map(function ($student) use ($story) {
            // Hitung total skor dari story ini
            $score = StudentAnswer::where('student_id', $student->id)
                ->whereIn('question_id', $story->stages->flatMap->questions->pluck('id'))
                ->sum('score_earned');

            // Ambil avatar yang dipilih
            $selectedAvatar = $student->avatars->firstWhere('pivot.is_selected', true);

            return [
                'name' => $student->user->name ?? 'Anonymous',
                'class' => $student->class,
                'score' => $score,
                'avatar_path' => $selectedAvatar?->image_path ?? 'default.png',
            ];
        })
        ->sortByDesc('score')
        ->values();

    return view('student.leaderboard.leaderboard', compact('story', 'students'));
}

}
