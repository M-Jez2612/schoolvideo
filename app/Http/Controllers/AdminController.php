<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Share;
use App\Models\Hashtag;
use App\Models\TestCase;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isGuru())) {
            abort(403, 'Akses khusus Admin dan Guru.');
        }

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::has('videos')->orHas('comments')->count(),
            'total_posts' => Video::count(),
            'total_comments' => Comment::count(),
            'total_likes' => Like::count(),
            'total_shares' => Share::count(),
        ];

        $topContent = Video::with(['user.profile', 'category'])
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $topUsers = User::with(['profile', 'role'])
            ->withCount(['videos', 'followers'])
            ->orderBy('videos_count', 'desc')
            ->take(5)
            ->get();

        $trendingTopics = Hashtag::orderBy('posts_count', 'desc')->take(6)->get();

        $pendingVideos = Video::with(['user.profile'])
            ->where('is_approved', false)
            ->latest()
            ->get();

        return view('admin.dashboard', compact('stats', 'topContent', 'topUsers', 'trendingTopics', 'pendingVideos'));
    }

    public function toggleApproval($id)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isGuru())) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $video = Video::findOrFail($id);
        $video->is_approved = !$video->is_approved;
        $video->save();

        return response()->json([
            'success' => true,
            'is_approved' => $video->is_approved,
        ]);
    }
}
