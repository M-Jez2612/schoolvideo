<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoHashtag extends Model
{
    // Tambahkan baris di bawah ini:
    protected $fillable = ['video_id', 'hashtag_id'];
}
