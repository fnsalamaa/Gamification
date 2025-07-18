<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\StudentAnswer;

class ChooseStoryController extends Controller
{
    public function index()
    {
        $stories = Story::all();
        return view('student.story.choose-story', compact('stories'));

    }


    public function showQuiz(Request $request, Story $story)
    {
        $stages = $story->stages()->with('questions')->get();
        $completedStages = session('completed_stages_' . $story->id, [0]); // default stage 0 terbuka

        // Ambil index stage & question dari query string (?stage=0&question=0)
        $stageIndex = (int) $request->query('stage', 0);
        $questionIndex = (int) $request->query('question', 0);

        $stage = $stages[$stageIndex] ?? null;
        $questions = $stage ? $stage->questions : collect();
        $question = $questions[$questionIndex] ?? null;
        $totalQuestions = $questions->count();

        $answer = null;
        if ($question && auth()->check()) {
            $studentId = auth()->user()->student->id;
            $answer = \App\Models\StudentAnswer::where('student_id', $studentId)
                ->where('question_id', $question->id)
                ->latest('attempt')
                ->first();
        }

        return view('student.story.read-story', compact(
            'story',
            'stages',
            'completedStages',
            'stageIndex',
            'questionIndex',
            'question',
            'totalQuestions',
            'answer'
        ));
    }


    // public function show($id)
// {
//     $story = Story::with('stages.questions')->findOrFail($id);
//     $stages = $story->stages->sortBy('order'); // optional jika ingin diurutkan

    //     return view('student.story.read-story', compact('story', 'stages'));
// }

    // public function submitFinal($storyId)
// {
//     $student = auth()->user();

    //     // Hitung total skor dari semua jawaban siswa untuk story ini
//     $totalScore = StudentAnswer::where('student_id', $student->id)
//         ->whereHas('question.stage', function ($q) use ($storyId) {
//             $q->where('story_id', $storyId);
//         })
//         ->sum('score_earned');

    //     // (Opsional) tandai story sebagai selesai, bisa buat tabel student_story

    //     return redirect()->route('quiz.result', $storyId)
//         ->with('success', "Kuis telah selesai! Skor total kamu: $totalScore");
// }

    // public function showResult($storyId)
// {
//     $student = auth()->user();

    //     $answers = StudentAnswer::with('question')
//         ->where('student_id', $student->id)
//         ->whereHas('question.stage', function ($q) use ($storyId) {
//             $q->where('story_id', $storyId);
//         })
//         ->get();

    //     $totalScore = $answers->sum('score_earned');
//     $totalQuestions = $answers->count();
//     $correctAnswers = $answers->where('is_correct', true)->count();
//     $incorrectAnswers = $answers->where('is_correct', false)->count();

    //     $story = \App\Models\Story::findOrFail($storyId);

    //     return view('student.result', compact(
//         'story',
//         'totalScore',
//         'totalQuestions',
//         'correctAnswers',
//         'incorrectAnswers',
//         'answers'
//     ));
// }


}
