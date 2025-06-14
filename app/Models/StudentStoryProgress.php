<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentStoryProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'story_id', 'is_completed', 'score_earned',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
