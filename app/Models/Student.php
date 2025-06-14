<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_score',
        'weekly_score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storyProgress()
    {
        return $this->hasMany(StudentStoryProgress::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function badges()
    {
        return $this->hasMany(StudentBadge::class);
    }

    public function avatars()
    {
        return $this->hasMany(StudentAvatar::class);
    }

    public function selectedAvatar()
    {
        return $this->hasOne(StudentAvatar::class)->where('is_selected', true);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function totalPoints()
    {
        return $this->attempts()->sum('point');
    }
}
