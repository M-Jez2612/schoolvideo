<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable = ['follower_id', 'followed_id'];

    public function followerUser()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function followedUser()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
