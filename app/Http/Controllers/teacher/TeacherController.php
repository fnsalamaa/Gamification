<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Story;
use App\Models\Question;
class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.dashboard');
    }

    public function showAllStudents()
    {
        $students = Student::with('user')->get();
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

}
