<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'icon'];

    public function awardedTo()
    {
        return $this->hasMany(StudentBadge::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_badges')
            ->withPivot(['is_unlocked', 'unlocked_at', 'awarded_at'])
            ->withTimestamps();
    }

}
