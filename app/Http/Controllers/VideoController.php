<?php

namespace App\Http\Controllers;

use App\Models\VideoHashtag;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Video;
use App\Models\Category;
class VideoController extends Controller
{
    public function showUploadForm()
    {
        $categories = Category::all();
        return view('video.upload', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:51200', // 50MB max
            'video_url_input' => 'nullable|string|url',
            'thumbnail_file' => 'nullable|image|max:5120',
            'hashtags_input' => 'nullable|string',
        ]);

        $videoUrl = 'https://assets.mixkit.co/videos/preview/mixkit-software-developer-working-on-code-41551-large.mp4';
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('videos', 'public');
            $videoUrl = asset('storage/' . $path);
        } elseif ($request->filled('video_url_input')) {
            $videoUrl = $request->video_url_input;
        }

        $thumbUrl = 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=80';
        if ($request->hasFile('thumbnail_file')) {
            $tpath = $request->file('thumbnail_file')->store('thumbnails', 'public');
            $thumbUrl = asset('storage/' . $tpath);
        }

        $video = Video::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $videoUrl,
            'thumbnail_url' => $thumbUrl,
            'duration' => rand(15, 60),
            'views_count' => 1,
            'likes_count' => 0,
            'comments_count' => 0,
            'shares_count' => 0,
            'is_short' => true,
            'is_approved' => true,
        ]);

        // Process Hashtags
        if ($request->filled('hashtags_input')) {
            $rawTags = explode(',', $request->hashtags_input);
            foreach ($rawTags as $tagStr) {
                $cleanTag = trim(str_replace('#', '', $tagStr));
                if (!empty($cleanTag)) {
                    $hashtag = Hashtag::firstOrCreate(['name' => $cleanTag]);
                    $hashtag->increment('posts_count');
                    VideoHashtag::firstOrCreate([
                        'video_id' => $video->id,
                        'hashtag_id' => $hashtag->id,
                    ]);
                }
            }
        } else {
            // Extract from description if any #
            preg_match_all('/#(\w+)/', $request->description, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $cleanTag) {
                    $hashtag = Hashtag::firstOrCreate(['name' => $cleanTag]);
                    $hashtag->increment('posts_count');
                    VideoHashtag::firstOrCreate([
                        'video_id' => $video->id,
                        'hashtag_id' => $hashtag->id,
                    ]);
                }
            }
        }

        return redirect()->route('video.show', $video->id)->with('success', 'Video Anda berhasil dipublikasikan!');
    }

    public function show($id)
    {
        $video = Video::with(['user.profile', 'category', 'comments.user.profile', 'hashtags'])->findOrFail($id);
        $video->increment('views_count');

        $relatedVideos = Video::with(['user.profile'])
            ->where('id', '!=', $video->id)
            ->where('category_id', $video->category_id)
            ->take(5)
            ->get();

        return view('video.show', compact('video', 'relatedVideos'));
    }

    public function stream($id)
    {
        $video = Video::findOrFail($id);
        $videoUrl = $video->video_url;

        $filePath = null;

        if (str_contains($videoUrl, '/storage/videos/')) {
            $parsed = parse_url($videoUrl, PHP_URL_PATH);
            $filename = basename($parsed);
            $candidate = storage_path('app/public/videos/' . $filename);
            if (file_exists($candidate)) {
                $filePath = $candidate;
            } elseif (file_exists(public_path('storage/videos/' . $filename))) {
                $filePath = public_path('storage/videos/' . $filename);
            }
        } elseif (str_starts_with($videoUrl, 'videos/')) {
            $candidate = storage_path('app/public/' . $videoUrl);
            if (file_exists($candidate)) {
                $filePath = $candidate;
            }
        } elseif (file_exists(public_path($videoUrl))) {
            $filePath = public_path($videoUrl);
        }

        if ($filePath && file_exists($filePath)) {
            $size = filesize($filePath);
            $mime = mime_content_type($filePath) ?: 'video/mp4';

            $start = 0;
            $end = $size - 1;
            $length = $size;
            $status = 200;

            $headers = [
                'Content-Type' => $mime,
                'Accept-Ranges' => 'bytes',
                'Cache-Control' => 'no-cache, private',
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
            ];

            if (request()->hasHeader('Range')) {
                $range = request()->header('Range');
                if (preg_match('/bytes=(\d+)-(\d*)/i', $range, $matches)) {
                    $start = intval($matches[1]);
                    if (!empty($matches[2])) {
                        $end = min(intval($matches[2]), $size - 1);
                    }
                    $length = $end - $start + 1;
                    $status = 206;
                    $headers['Content-Range'] = "bytes {$start}-{$end}/{$size}";
                }
            }

            $headers['Content-Length'] = $length;

            return response()->stream(function () use ($filePath, $start, $length) {
                if (ob_get_level()) {
                    @ob_end_clean();
                }
                $fp = fopen($filePath, 'rb');
                if (!$fp) return;
                fseek($fp, $start);
                $remaining = $length;
                $bufferSize = 1024 * 64;

                while (!feof($fp) && $remaining > 0 && !connection_aborted()) {
                    $bytesToRead = min($bufferSize, $remaining);
                    echo fread($fp, $bytesToRead);
                    flush();
                    $remaining -= $bytesToRead;
                }
                fclose($fp);
            }, $status, $headers);
        }

        if (filter_var($videoUrl, FILTER_VALIDATE_URL)) {
            return redirect()->away($videoUrl);
        }

        abort(404, 'Video file not found.');
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);

        if ($video->user_id !== Auth::id() && !Auth::user()->isGuru()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit video ini.');
        }

        $categories = Category::all();
        return view('video.edit', compact('video', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        if ($video->user_id !== Auth::id() && !Auth::user()->isGuru()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail_file' => 'nullable|image|max:5120',
            'thumbnail_url_input' => 'nullable|string|url',
            'hashtags_input' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('thumbnail_file')) {
            $tpath = $request->file('thumbnail_file')->store('thumbnails', 'public');
            $data['thumbnail_url'] = asset('storage/' . $tpath);
        } elseif ($request->filled('thumbnail_url_input')) {
            $data['thumbnail_url'] = $request->thumbnail_url_input;
        }

        $video->update($data);

        if ($request->has('hashtags_input')) {
            $rawTags = explode(',', $request->hashtags_input);
            $tagIds = [];
            foreach ($rawTags as $tagStr) {
                $cleanTag = trim(str_replace('#', '', $tagStr));
                if (!empty($cleanTag)) {
                    $hashtag = Hashtag::firstOrCreate(['name' => $cleanTag]);
                    $hashtag->increment('posts_count');
                    $tagIds[] = $hashtag->id;
                }
            }
            $video->hashtags()->sync($tagIds);
        }

        return redirect()->route('video.show', $video->id)->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        if ($video->user_id !== Auth::id() && !Auth::user()->isGuru()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus video ini.');
        }

        $video->delete();

        return redirect()->route('feed')->with('success', 'Video berhasil dihapus.');
    }
}
