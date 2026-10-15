<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Video;
use App\Models\Like;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::with(['profile', 'role', 'student.schoolClass', 'student.major', 'teacher'])->findOrFail($id);

        $videos = Video::with(['category', 'hashtags'])
            ->where('user_id', $user->id)
            ->where('is_approved', true)
            ->latest()
            ->get();

        $likedVideoIds = Like::where('user_id', $user->id)->pluck('video_id');
        $likedVideos = Video::with(['user.profile', 'category'])
            ->whereIn('id', $likedVideoIds)
            ->where('is_approved', true)
            ->latest()
            ->get();

        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        $totalLikesReceived = Video::where('user_id', $user->id)->sum('likes_count');

        return view('profile.show', compact('user', 'videos', 'likedVideos', 'followersCount', 'followingCount', 'totalLikesReceived'));
    }

    public function edit()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $request->validate([
            'name' => 'required|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar_file' => 'nullable|image|max:2048',
        ]);

        $user->update(['name' => $request->name]);

        $profileData = [
            'full_name' => $request->full_name ?? $request->name,
            'bio' => $request->bio,
        ];

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $profileData['avatar_url'] = asset('storage/' . $path);
        }

        $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);

        return redirect()->route('profile.show', $user->id)->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
