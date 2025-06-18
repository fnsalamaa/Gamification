<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentBadge extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'badge_id', 'is_unlocked', 'unlocked_at', 'awarded_at'];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
}
