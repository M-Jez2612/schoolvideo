<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'video_url',
        'thumbnail_url',
        'duration',
        'views_count',
        'likes_count',
        'comments_count',
        'shares_count',
        'is_short',
        'is_featured',
        'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'video_hashtags');
    }

    public function interactions()
    {
        return $this->hasMany(UserInteraction::class);
    }

    public function getPlayUrlAttribute()
    {
        if (str_contains($this->video_url, '/storage/videos/') || str_starts_with($this->video_url, 'videos/')) {
            return route('video.stream', $this->id);
        }
        return $this->video_url;
    }

    /**
     * Calculate Recommendation Score according to Bab 6.3 & Tender Document (TikTok-style)
     * Recommendation Score = (View * 0.5) + (Like * 1.0) + (Comment * 3.0) + (Share * 4.0) + (Interest Match * 20) + (Interaction History * 15)
     */
    public function getRecommendationScoreAttribute()
    {
        $viewScore = $this->views_count * 0.5;
        $likeScore = $this->likes_count * 1.0;
        $commentScore = $this->comments_count * 3.0;
        $shareScore = $this->shares_count * 4.0;
        
        // Mocked interest and interaction weight based on recency and engagement
        $interestMatch = $this->is_featured ? 1.0 : 0.8;
        $interactionHistory = min(1.0, ($this->likes_count + $this->comments_count * 2) / 20);

        return round($viewScore + $likeScore + $commentScore + $shareScore + ($interestMatch * 20) + ($interactionHistory * 15), 2);
    }

    /**
     * Calculate Trending Score according to Bab 6.5 & Tender Document
     * Trending Score = (Post Volume * 0.20) + (Growth * 0.40) + (Engagement * 0.25) + (Recency * 0.15)
     */
    public function getTrendingScoreAttribute()
    {
        $hoursAgo = max(1, $this->created_at->diffInHours(now()));
        $recencyScore = max(0, 100 - ($hoursAgo * 2));
        $engagementTotal = ($this->likes_count * 2) + ($this->comments_count * 3) + ($this->shares_count * 4);
        $growthScore = min(100, ($this->views_count / $hoursAgo) * 5);
        $postVolume = 75; // Average topic post density

        return round(($postVolume * 0.20) + ($growthScore * 0.40) + ($engagementTotal * 0.25) + ($recencyScore * 0.15), 2);
    }

    /**
     * Calculate Search Score for a given keyword query (Bab 6.1)
     * Search Score = (Keyword Match * 0.40) + (Relevance * 0.25) + (Popularity * 0.20) + (Recency * 0.15)
     */
    public function calculateSearchScore($keyword)
    {
        if (empty($keyword)) return $this->recommendation_score;

        $kw = strtolower($keyword);
        $titleMatch = str_contains(strtolower($this->title), $kw) ? 100 : 0;
        $descMatch = str_contains(strtolower($this->description ?? ''), $kw) ? 60 : 0;
        $kwMatch = max($titleMatch, $descMatch);

        $relevance = $this->category ? (str_contains(strtolower($this->category->name), $kw) ? 100 : 70) : 50;
        $popularity = min(100, ($this->views_count * 0.5 + $this->likes_count * 2));
        $hoursAgo = max(1, $this->created_at->diffInHours(now()));
        $recency = max(10, 100 - ($hoursAgo * 1.5));

        return round(($kwMatch * 0.40) + ($relevance * 0.25) + ($popularity * 0.20) + ($recency * 0.15), 2);
    }
}
