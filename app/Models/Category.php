<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRandomVideos(int $count)
    {
        return $this->videos()->inRandomOrder()->get()->take($count);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
