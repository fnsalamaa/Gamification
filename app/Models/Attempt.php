<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attempt extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'attempt_number',
        'is_correct',
        'point',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
