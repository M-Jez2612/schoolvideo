<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Models\Hashtag;

class FeedController extends Controller
{
    public function forYou(Request $request)
    {
        $query = Video::with(['user.profile', 'category', 'comments.user.profile', 'hashtags'])
            ->where('is_approved', true);

        // Fetch videos and calculate Recommendation Score algorithm (TikTok-style)
        $videos = $query->get()->sortByDesc(function ($video) {
            return $video->recommendation_score;
        })->values();

        $trendingHashtags = Hashtag::orderBy('posts_count', 'desc')->take(5)->get();
        $feedType = 'for-you';

        return view('feed.index', compact('videos', 'trendingHashtags', 'feedType'));
    }

    public function following(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $followingIds = $user->following()->pluck('followed_id');

        $videos = Video::with(['user.profile', 'category', 'comments.user.profile', 'hashtags'])
            ->whereIn('user_id', $followingIds)
            ->where('is_approved', true)
            ->latest()
            ->get();

        // If following is empty, fallback to recent videos
        if ($videos->isEmpty()) {
            $videos = Video::with(['user.profile', 'category', 'comments.user.profile', 'hashtags'])
                ->where('is_approved', true)
                ->latest()
                ->take(10)
                ->get();
        }

        $trendingHashtags = Hashtag::orderBy('posts_count', 'desc')->take(5)->get();
        $feedType = 'following';

        return view('feed.index', compact('videos', 'trendingHashtags', 'feedType'));
    }
}
