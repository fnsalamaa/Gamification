<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;

class StudentAnswerController extends Controller
{

public function showStoryScore($storyId)
{
    $studentId = auth()->id();

    // Ambil semua question ID dari story tertentu
    $questionIds = \App\Models\Story::findOrFail($storyId)
        ->stages()
        ->with('questions')
        ->get()
        ->pluck('questions')
        ->flatten()
        ->pluck('id');

    // Hitung skor earned dari jawaban yang berkaitan dengan story ini
    $totalScore = StudentAnswer::where('student_id', $studentId)
        ->whereIn('question_id', $questionIds)
        ->sum('score_earned');

    $maxScore = count($questionIds) * 5;

    return view('student.quiz.result', [
        'totalScore' => $totalScore,
        'maxScore' => $maxScore,
        'story' => \App\Models\Story::find($storyId)
    ]);
}

public function showOverallScore()
{
    $studentId = auth()->id();

    $totalScore = StudentAnswer::where('student_id', $studentId)->sum('score_earned');
    $maxPossibleScore = StudentAnswer::where('student_id', $studentId)->count() * 5;

    return view('student.quiz.overall-score', [
        'totalScore' => $totalScore,
        'maxScore' => $maxPossibleScore
    ]);
}

}
