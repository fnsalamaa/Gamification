<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;

class ChooseStoryController extends Controller
{
    public function index()
    {
        $stories = Story::all();
        return view('student.story.choose-story', compact('stories'));

    }

//     public function choose($id)
// {
//     $story = Story::findOrFail($id);
//     // Simpan pilihan ke session atau database, tergantung logika kamu
//     session(['chosen_story_id' => $story->id]);

//     return redirect()->route('student.story.read', $story->id);
// }

public function show($id)
{
    $story = Story::with('stages.questions')->findOrFail($id);
    $stages = $story->stages->sortBy('order'); // optional jika ingin diurutkan

    return view('student.story.read-story', compact('story', 'stages'));
}

}
