<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;
use App\Models\Hashtag;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
        $categoryId = $request->get('category', '');

        $videosQuery = Video::with(['user.profile', 'category', 'hashtags'])
            ->where('is_approved', true);

        if (!empty($categoryId)) {
            $videosQuery->where('category_id', $categoryId);
        }

        if (!empty($q)) {
            $videosQuery->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhereHas('hashtags', function ($ht) use ($q) {
                        $ht->where('name', 'like', "%{$q}%");
                    });
            });
        }

        $videos = $videosQuery->latest()->get();

        $users = [];
        if (!empty($q)) {
            $users = User::with(['profile', 'role'])
                ->where('name', 'like', "%{$q}%")
                ->orWhere('username', 'like', "%{$q}%")
                ->take(6)
                ->get();
        }

        // Limit top trending hashtags display to max 10 popular tags to prevent cluttering
        $trendingHashtags = Hashtag::orderBy('posts_count', 'desc')->take(10)->get();
        $categories = Category::all();

        return view('search.index', compact('videos', 'users', 'trendingHashtags', 'categories', 'q', 'categoryId'));
    }

    public function showHashtag($name)
    {
        $cleanName = str_replace('#', '', $name);
        $hashtag = Hashtag::where('name', $cleanName)->firstOrFail();

        $videos = $hashtag->videos()
            ->with(['user.profile', 'category'])
            ->where('is_approved', true)
            ->latest()
            ->get();

        $trendingHashtags = Hashtag::orderBy('posts_count', 'desc')->take(10)->get();

        return view('search.hashtag', compact('hashtag', 'videos', 'trendingHashtags'));
    }
}
