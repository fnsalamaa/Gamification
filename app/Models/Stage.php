<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stage extends Model
{
    use HasFactory;

    
    // Kolom yang bisa diisi massal dari form/input
    protected $fillable = ['story_id', 'stage_type', 'order'];

    // Relasi ke model Story
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    // Relasi ke model Question
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    
}

