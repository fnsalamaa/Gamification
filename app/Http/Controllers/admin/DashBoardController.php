<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Story;


class DashBoardController extends Controller
{


    public function index()
    {
        $totalUsers = User::count();
        $totalStories = Story::count();
        $totalQuestions = Question::count();
        // $totalStudents = User::role('user')->count(); 

        return view('admin.dashboard', compact('totalUsers', 'totalStories', 'totalQuestions'));
    }

}
