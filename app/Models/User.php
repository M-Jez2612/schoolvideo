<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function followers()
    {
        return $this->hasMany(Follower::class, 'followed_id');
    }

    public function following()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function isFollowing($userId)
    {
        return $this->following()->where('followed_id', $userId)->exists();
    }

    public function hasLiked($videoId)
    {
        return $this->likes()->where('video_id', $videoId)->exists();
    }

    public function isAdmin()
    {
        return $this->role && strtolower($this->role->name) === 'admin';
    }

    public function isGuru()
    {
        return $this->role && (strtolower($this->role->name) === 'guru' || strtolower($this->role->name) === 'admin');
    }

    public function isSiswa()
    {
        return $this->role && strtolower($this->role->name) === 'siswa';
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->profile && $this->profile->avatar_url) {
            return $this->profile->avatar_url;
        }
        return 'https://api.dicebear.com/7.x/bottts/svg?seed=' . urlencode($this->username ?? $this->name);
    }
}
