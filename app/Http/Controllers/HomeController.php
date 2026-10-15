<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\SchoolProfile;
use App\Models\Hashtag;
use App\Models\User;
use App\Models\Category;

class HomeController extends Controller
{
    public function landing()
    {
        $school = SchoolProfile::first();
        $featuredVideos = Video::with(['user.profile', 'category'])
            ->where('is_approved', true)
            ->orderBy('likes_count', 'desc')
            ->take(6)
            ->get();

        $trendingHashtags = Hashtag::orderBy('posts_count', 'desc')->take(6)->get();
        $categories = Category::all();
        $stats = [
            'total_users' => User::count(),
            'total_videos' => Video::count(),
            'total_likes' => Video::sum('likes_count'),
            'total_views' => Video::sum('views_count'),
        ];

        return view('landing', compact('school', 'featuredVideos', 'trendingHashtags', 'categories', 'stats'));
    }
}
