<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Share;
use App\Models\Follower;
use App\Models\User;

class InteractionController extends Controller
{
    public function toggleLike(Request $request, $videoId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $userId = Auth::id();
        $video = Video::findOrFail($videoId);

        $like = Like::where('user_id', $userId)->where('video_id', $videoId)->first();

        if ($like) {
            $like->delete();
            $video->decrement('likes_count');
            $liked = false;
        } else {
            Like::create(['user_id' => $userId, 'video_id' => $videoId]);
            $video->increment('likes_count');
            $liked = true;

            if ($video->user_id !== $userId) {
                Notification::create([
                    'user_id' => $video->user_id,
                    'sender_id' => $userId,
                    'type' => 'like',
                    'message' => Auth::user()->name . ' menyukai video Anda: "' . $video->title . '"',
                    'link' => route('video.show', $video->id),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $video->fresh()->likes_count,
        ]);
    }

    public function addComment(Request $request, $videoId)
    {
        if (!Auth::check()) {
            if (!$request->expectsJson() && !$request->ajax()) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk berkomentar.');
            }
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $video = Video::findOrFail($videoId);
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $videoId,
            'content' => $request->content,
        ]);

        $video->increment('comments_count');

        if ($video->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $video->user_id,
                'sender_id' => Auth::id(),
                'type' => 'comment',
                'message' => Auth::user()->name . ' mengomentari video Anda: "' . $request->content . '"',
                'link' => route('video.show', $video->id),
            ]);
        }

        if (!$request->expectsJson() && !$request->ajax()) {
            return redirect()->route('video.show', $videoId)->with('success', 'Komentar berhasil ditambahkan!');
        }

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'user_name' => Auth::user()->name,
                'avatar_url' => Auth::user()->avatar_url,
                'content' => $comment->content,
                'time_ago' => 'Baru saja',
            ],
            'comments_count' => $video->fresh()->comments_count,
        ]);
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if ($comment->user_id !== Auth::id() && !Auth::user()->isGuru()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $video = Video::find($comment->video_id);
        $comment->delete();

        if ($video) {
            $video->decrement('comments_count');
        }

        return response()->json(['success' => true]);
    }

    public function share(Request $request, $videoId)
    {
        $video = Video::findOrFail($videoId);
        $video->increment('shares_count');

        if (Auth::check()) {
            Share::create([
                'user_id' => Auth::id(),
                'video_id' => $videoId,
                'platform' => $request->get('platform', 'link'),
            ]);
        }

        return response()->json([
            'success' => true,
            'shares_count' => $video->shares_count,
            'share_url' => route('video.show', $video->id),
        ]);
    }

    public function toggleFollow(Request $request, $userId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $myId = Auth::id();
        if ($myId == $userId) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat mengikuti diri sendiri'], 400);
        }

        $targetUser = User::findOrFail($userId);
        $follow = Follower::where('follower_id', $myId)->where('followed_id', $userId)->first();

        if ($follow) {
            $follow->delete();
            $following = false;
        } else {
            Follower::create(['follower_id' => $myId, 'followed_id' => $userId]);
            $following = true;

            Notification::create([
                'user_id' => $userId,
                'sender_id' => $myId,
                'type' => 'follow',
                'message' => Auth::user()->name . ' mulai mengikuti Anda.',
                'link' => route('profile.show', $myId),
            ]);
        }

        return response()->json([
            'success' => true,
            'following' => $following,
            'followers_count' => $targetUser->followers()->count(),
        ]);
    }
}
