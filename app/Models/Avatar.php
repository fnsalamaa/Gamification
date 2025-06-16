<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avatar extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image_path', 'unlock_condition'];

    public function unlockedBy()
    {
        return $this->hasMany(StudentAvatar::class);
    }

    public function students()
{
    return $this->belongsToMany(Student::class, 'student_avatars')
                ->withPivot('is_unlocked', 'is_selected', 'unlocked_at')
                ->withTimestamps();
}

}
