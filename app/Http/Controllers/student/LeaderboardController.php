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
                'id' => $student->id,
                'name' => $student->user->name ?? 'Anonymous',
                'class' => $student->class,
                'score' => $score,
                'avatar_path' => $selectedAvatar?->image_path ?? 'default.png',
            ];
        })
        ->sortByDesc('score')
        ->values();

         // ✅ Unlock avatar khusus juara 1 cerita ini
    if ($students->isNotEmpty()) {
        $topStudentId = $students->first()['id'];

        $slug = str($story->title)->slug('_'); // Contoh: "Timun Mas" → "timun_mas"

        $avatar = \App\Models\Avatar::where('unlock_condition', 'story_' . $slug . '_1')->first();

        if ($avatar) {
            \App\Models\StudentAvatar::updateOrCreate(
                [
                    'student_id' => $topStudentId,
                    'avatar_id' => $avatar->id,
                ],
                [
                    'is_unlocked' => true,
                    'unlocked_at' => now(),
                ]
            );
        }
    }

    return view('student.leaderboard.leaderboard', compact('story', 'students'));
}


public function global()
{
    $students = Student::with(['user', 'avatars', 'answers'])->get()
        ->map(function ($student) {
            $score = $student->answers->sum('score_earned');

            $selectedAvatar = $student->avatars->firstWhere('pivot.is_selected', true);

            return [
                'id' => $student->id,
                'name' => $student->user->name ?? 'Anonymous',
                'class' => $student->class,
                'score' => $score,
                'avatar_path' => $selectedAvatar?->image_path ?? 'default.png',
                 'user' => [
        'profile_photo_path' => $student->user->profile_photo_path ?? null,
    ]
            ];
        })
        ->filter(fn ($s) => $s['score'] > 0)
        ->sortByDesc('score')
        ->values(); // penting! supaya indexnya berurutan mulai 0

    $allStories = Story::all();

    return view('student.leaderboard.global', compact('students', 'allStories'));
}



}
