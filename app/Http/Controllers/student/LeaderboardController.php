<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Student;
use App\Models\StudentAnswer;

class LeaderboardController extends Controller
{
    public function show(Story $story)
    {
        $questionIds = $story->stages->flatMap->questions->pluck('id');

        $students = Student::with(['user', 'avatars'])->get()
            ->map(function ($student) use ($questionIds) {
                $answers = StudentAnswer::where('student_id', $student->id)
                    ->whereIn('question_id', $questionIds)
                    ->get();

                $score = $answers->sum('score_earned');
                $latestAnswerTime = $answers->max('created_at'); // bisa null

                $selectedAvatar = $student->avatars->firstWhere('pivot.is_selected', true);

                return [
                    'id' => $student->id,
                    'name' => $student->user->name ?? 'Anonymous',
                    'class' => $student->class,
                    'score' => $score,
                    'latest_time' => $latestAnswerTime, // null jika belum pernah jawab
                    'avatar_path' => $selectedAvatar?->image_path ?? 'default.png',
                ];
            })
            ->sort(function ($a, $b) {
                $timeA = $a['latest_time'] ? $a['latest_time']->timestamp : PHP_INT_MAX;
                $timeB = $b['latest_time'] ? $b['latest_time']->timestamp : PHP_INT_MAX;
                return [$b['score'], $timeA] <=> [$a['score'], $timeB];
            })
            ->values();

        // ✅ Unlock avatar juara 1
        if ($students->isNotEmpty()) {
            $topStudentId = $students->first()['id'];
            $slug = str($story->title)->slug('_');
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
                $answers = $student->answers;
                $score = $answers->sum('score_earned');
                $latestAnswerTime = $answers->max('created_at'); // bisa null

                $selectedAvatar = $student->avatars->firstWhere('pivot.is_selected', true);
                $avatarPath = $selectedAvatar?->image_path ?? 'avatars/special.jpg';

                return [
                    'id' => $student->id,
                    'name' => $student->user->name ?? 'Anonymous',
                    'class' => $student->class,
                    'score' => $score,
                    'latest_time' => $latestAnswerTime, // null jika belum pernah jawab
                    'avatar_path' => $avatarPath,
                    'user' => [
                        'profile_photo_path' => $student->user->profile_photo_path ?? null,
                    ]
                ];
            })
            ->sort(function ($a, $b) {
                $timeA = $a['latest_time'] ? $a['latest_time']->timestamp : PHP_INT_MAX;
                $timeB = $b['latest_time'] ? $b['latest_time']->timestamp : PHP_INT_MAX;
                return [$b['score'], $timeA] <=> [$a['score'], $timeB];
            })
            ->values();

        $allStories = Story::all();

        return view('student.leaderboard.global', compact('students', 'allStories'));
    }
}
