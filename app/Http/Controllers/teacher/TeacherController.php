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

}
