<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentAnswer;

class StudentAnswerController extends Controller
{
    public function submitAnswer(Request $request)
{
    $request->validate([
        'question_id' => 'required|integer|exists:questions,id',
        'selected_option' => 'required|string|in:A,B,C,D',
    ]);

    $studentId = auth()->id();
    $question = Question::findOrFail($request->question_id);
    $selected = $request->selected_option;

    $correct = $question->correct_answer;
    $isCorrect = $selected === $correct;

    $existing = StudentAnswer::where('student_id', $studentId)
        ->where('question_id', $question->id)
        ->first();

    if ($existing) {
        if ($existing->is_correct) {
            return response()->json(['message' => 'Already correct'], 200);
        }

        $existing->attempts += 1;

        if ($isCorrect) {
            $existing->is_correct = true;
            $existing->score_earned = match ($existing->attempts) {
                1 => 5,
                2 => 3,
                3 => 1,
                default => 0,
            };
        }

        $existing->selected_option = $selected;
        $existing->save();

        return response()->json([
            'correct' => $isCorrect,
            'points' => $existing->score_earned,
            'attempts' => $existing->attempts,
        ]);
    } else {
        $attempts = 1;
        $points = $isCorrect ? 5 : 0;

        StudentAnswer::create([
            'student_id' => $studentId,
            'question_id' => $question->id,
            'selected_option' => $selected,
            'attempts' => $attempts,
            'is_correct' => $isCorrect,
            'score_earned' => $points,
        ]);

        return response()->json([
            'correct' => $isCorrect,
            'points' => $points,
            'attempts' => $attempts,
        ]);
    }
}

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
