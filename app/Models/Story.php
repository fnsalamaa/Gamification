<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal (wajib jika pakai create atau fill())
    protected $fillable = ['title', 'cover'];

    // Relasi ke model Stage
    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_answers')
            ->withPivot('score')
            ->withTimestamps();
    }

}
