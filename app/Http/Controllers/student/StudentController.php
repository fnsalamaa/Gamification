<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
   

public function index()
{
    $student = Auth::user()->student;

    // Ambil avatar yang dipilih (is_selected = true)
    $selectedAvatar = $student->avatars()->wherePivot('is_selected', true)->first();

    return view('student.dashboard', compact('student', 'selectedAvatar'));
}

}