<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAvatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'avatar_id', 'is_unlocked', 'is_selected', 'unlocked_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }   
}
