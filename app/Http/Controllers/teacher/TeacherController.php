<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Story;
use App\Models\Question;
use App\Models\StudentAnswer;
use Illuminate\Pagination\Paginator;

class TeacherController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalStories = Story::count();
        $totalQuestions = Question::count();

        $latestStories = Story::latest()->take(5)->get();

        return view('teacher.dashboard', compact(
            'totalStudents',
            'totalStories',
            'totalQuestions',

            'latestStories'
        ));
    }


    public function showAllStudents()
    {
        $students = Student::with('user')->paginate(10);
        return view('teacher.student.show-student', compact('students'));
    }

    public function showAllStories()
    {
        $stories = Story::all();
        return view('teacher.story.show-story', compact('stories'));
    }

    public function showStoryDetail($id)
    {
        $story = Story::with('stages.questions')->findOrFail($id);

        // Ambil semua questions dari semua stages
        $questions = $story->stages->flatMap(function ($stage) {
            return $stage->questions;
        });

        return view('teacher.story.detail-story', compact('story', 'questions'));
    }

    public function showLeaderboard(Request $request)
    {
        $type = $request->query('type', 'story');

        if ($type === 'global') {
            $students = Student::with('user')
                ->orderByDesc('total_score')
                ->paginate(10)
                ->appends(['type' => 'global']);


            return view('teacher.leaderboard.index', compact('type', 'students'));
        } else {
            $selectedStoryId = $request->query('story_id');
            $stories = Story::all();

            $storyScores = [];

            if ($selectedStoryId) {
                $story = Story::findOrFail($selectedStoryId);

                $studentScores = StudentAnswer::select('student_id')
                    ->selectRaw('SUM(score_earned) as total_score')
                    ->whereHas('question.stage', function ($query) use ($story) {
                        $query->where('story_id', $story->id);
                    })
                    ->groupBy('student_id')
                    ->with('student.user')
                    ->orderByDesc('total_score')
                    ->paginate(10)
                    ->appends([
                        'type' => 'story',
                        'story_id' => $story->id
                    ]);

                $storyScores[] = [
                    'story' => $story,
                    'students' => $studentScores
                ];
            }

            return view('teacher.leaderboard.index', compact('type', 'stories', 'storyScores', 'selectedStoryId'));
        }
    }

    public function studentProgress()
    {
        $students = Student::with(['user', 'answers'])->get();

        $progress = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->user->name ?? '-',
                'answered' => $student->answers->count(),
                'correct' => $student->answers->where('is_correct', 1)->count(),
                'score' => $student->answers->sum('score_earned'),
                'attempt' => $student->answers->pluck('attempt')->unique()->count(),
            ];
        });

        return view('teacher.student.student-progress', compact('progress'));
    }

    public function showStudentProgressDetail($id)
    {
        $student = Student::with(['user', 'answers'])->findOrFail($id);

        $studentsWithScores = Student::with('answers')->get()->map(function ($s) {
            return [
                'id' => $s->id,
                'score' => $s->answers->sum('score_earned'),
            ];
        })->sortByDesc('score')->values(); // Reset index biar bisa cari ranking

        // Cari ranking student
        $rank = $studentsWithScores->search(fn($s) => $s['id'] == $student->id) + 1;

        $progress = [
            'id' => $student->id,
            'name' => $student->user->name ?? '-',
            'answered' => $student->answers->count(),
            'correct' => $student->answers->where('is_correct', 1)->count(),
            'score' => $student->answers->sum('score_earned'),
            'rank' => $rank,
        ];

        return view('teacher.student.student-progress-detail', compact('progress', 'student'));
    }



    public function showStudentAnswerDetail($id)
    {
        $student = Student::with(['user', 'answers.question.stage.story'])->findOrFail($id);

        $answers = $student->answers
            ->sortBy(['question_id', 'attempt']) // urutkan berdasarkan question_id lalu attempt
            ->groupBy(fn($answer) => $answer->question->stage->story->id)
            ->map(function ($answersByStory) {
                return $answersByStory->groupBy(fn($answer) => $answer->question->stage->id)
                    ->map(function ($answersByStage) {
                        // Di dalam stage, group by question_id agar bisa melihat multiple attempts
                        return $answersByStage->groupBy('question_id');
                    });
            });

        return view('teacher.student.student-answer-detail', [
            'student' => $student,
            'groupedAnswers' => $answers
        ]);
    }






}
