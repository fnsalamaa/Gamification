<?php


namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    
    public function storeMultiple(Request $request, $stageId)
{
    $validatedData = $request->validate([
        'questions.*.narrative' => 'required',
        'questions.*.question_text' => 'required',
        'questions.*.option_a' => 'required',
        'questions.*.option_b' => 'required',
        'questions.*.option_c' => 'required',
        'questions.*.option_d' => 'required',
        'questions.*.correct_answer' => 'required|in:A,B,C,D',
        'questions.*.image' => 'nullable|image|max:2048',
    ]);

    foreach ($request->questions as $q) {
        $question = new Question();
        $question->stage_id = $stageId;
        $question->narrative = $q['narrative'];
        $question->question_text = $q['question_text'];
        $question->option_a = $q['option_a'];
        $question->option_b = $q['option_b'];
        $question->option_c = $q['option_c'];
        $question->option_d = $q['option_d'];
        $question->correct_answer = $q['correct_answer'];

        if (isset($q['image'])) {
            $imagePath = $q['image']->store('questions', 'public');
            $question->image = $imagePath;
        }

        $question->save();
    }

    return redirect()->back()->with('success', 'Semua soal berhasil disimpan.');
}

public function edit($id)
{
    $question = Question::findOrFail($id);
    return view('admin.questions.edit', compact('question'));
}

public function update(Request $request, $id)
{
    $question = Question::findOrFail($id);

    $validatedData = $request->validate([
        'narrative' => 'required',
        'question_text' => 'required',
        'option_a' => 'required',
        'option_b' => 'required',
        'option_c' => 'required',
        'option_d' => 'required',
        'correct_answer' => 'required|in:A,B,C,D',
        'image' => 'nullable|image|max:2048',
    ]);

    $question->narrative = $request->narrative;
    $question->question_text = $request->question_text;
    $question->option_a = $request->option_a;
    $question->option_b = $request->option_b;
    $question->option_c = $request->option_c;
    $question->option_d = $request->option_d;
    $question->correct_answer = $request->correct_answer;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('questions', 'public');
        $question->image = $imagePath;
    }

    $question->save();

    return redirect()->back()->with('success', 'Soal berhasil diperbarui.');
}

public function destroy($id)
{
    $question = Question::findOrFail($id);

    // Hapus gambar jika ada
    if ($question->image) {
        Storage::disk('public')->delete($question->image);
    }

    $question->delete();

    return redirect()->back()->with('success', 'Soal berhasil dihapus.');
}


}
