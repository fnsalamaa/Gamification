<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avatar extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image_path', 'unlock_condition'];

    public function unlockedBy()
    {
        return $this->hasMany(StudentAvatar::class);
    }
}
