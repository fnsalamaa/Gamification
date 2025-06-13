<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
    'stage_id',
    'narrative',
    'image_path',
    'question_text',
    'option_a',
    'option_b',
    'option_c',
    'option_d',
    'correct_answer',
];

    public function stage()
{
    return $this->belongsTo(Stage::class);
}

}
