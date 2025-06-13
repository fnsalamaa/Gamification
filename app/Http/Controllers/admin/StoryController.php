<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story; 
class StoryController extends Controller
{
// StoryController.php
public function index()
{
    $stories = Story::all();
    return view('admin.story.create-story', compact('stories'));
}

public function store(Request $request)
{
    
    $request->validate([
        'title' => 'required|string|max:255',
        'cover' => 'required|image|max:2048',
    ]);
    

    $path = $request->file('cover')->store('story-covers', 'public');

    Story::create([
        'title' => $request->title,
        'cover' => $path,
    ]);

    return redirect()->back()->with('success', 'Story berhasil ditambahkan.');
    
    
}

public function addDetail($id)
{
    $story = Story::findOrFail($id);
    // Cek apakah stages sudah ada
    if ($story->stages()->count() === 0) {
        $defaultStages = [
            ['stage_type' => 'opening', 'order' => 1],
            ['stage_type' => 'main_event', 'order' => 2],
            ['stage_type' => 'main_event', 'order' => 3],
            ['stage_type' => 'closure', 'order' => 4],
        ];

        foreach ($defaultStages as $stage) {
            $story->stages()->create($stage);
        }
    }

    $stages = $story->stages()->with('questions')->orderBy('order')->get();

    return view('admin.story.detail-story', compact('story', 'stages'));
}

public function storeDetail(Request $request, $id)
{
    // $request->validate([
    //     'detail' => 'required|string',
    // ]);

    $story = Story::findOrFail($id);
    $story->title = $request->input('title'); // meskipun readonly, tetap bisa simpan
    $story->save();


    // Simpan detailnya, misal ke tabel stage (kalau punya relasi stages)
    $story->stages()->create([
        'name' => $request->detail,
        // tambah field lain jika ada
    ]);

    return redirect()->route('admin.story.create-story')->with('success', 'Detail berhasil ditambahkan.');
}

public function destroy($id)
{
    $story = Story::findOrFail($id);

    // Hapus file cover dari storage (jika ada)
    if ($story->cover && \Storage::disk('public')->exists($story->cover)) {
        \Storage::disk('public')->delete($story->cover);
    }

    // Hapus data story dari database
    $story->delete();

    return redirect()->back()->with('success', 'Story berhasil dihapus.');
}


}
