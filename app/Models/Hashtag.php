<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = ['name', 'posts_count'];

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'video_hashtags');
    }
}
