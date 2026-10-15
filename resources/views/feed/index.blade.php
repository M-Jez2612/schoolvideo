@extends('layouts.app')

@section('title', 'TikTok Feed - SchoolVideo')

@section('styles')
<style>
    .feed-viewport {
        scroll-snap-type: y mandatory;
        overflow-y: scroll;
        height: 100vh;
        width: 100%;
        scroll-behavior: smooth;
    }
    .feed-card {
        scroll-snap-align: start;
        height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .heart-pop {
        position: absolute;
        pointer-events: none;
        animation: heartPop 0.8s ease-out forwards;
        z-index: 60;
    }
    @keyframes heartPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        50% { transform: scale(1.4) rotate(0deg); opacity: 1; }
        100% { transform: scale(1) translateY(-60px); opacity: 0; }
    }
</style>
@endsection

@section('content')
<div class="relative w-full h-full bg-black flex justify-center items-center">

    <!-- Top Far Right Bar (TikTok Web Top Right Header) -->
    <div class="fixed top-4 right-6 z-40 hidden md:flex items-center space-x-3">
        <a href="{{ route('school.profile') }}" class="px-4 py-2 rounded-full bg-neutral-900 border border-neutral-800 text-xs font-bold text-neutral-300 hover:text-white transition">
            Dapatkan Aplikasi
        </a>
        @guest
            <a href="{{ route('login') }}" class="px-5 py-2 rounded-full bg-tiktok-red font-bold text-white text-xs hover:opacity-90 transition">
                Log masuk
            </a>
        @endguest
    </div>

    <!-- Scroll Up / Down Floating Nav Buttons (Matching TikTok Screenshot Far Right) -->
    <div class="fixed right-6 bottom-24 z-40 hidden lg:flex flex-col space-y-3">
        <button onclick="scrollToPrevVideo()" class="w-10 h-10 rounded-full bg-neutral-900 hover:bg-neutral-800 text-white flex items-center justify-center border border-neutral-800 shadow-xl transition">
            <i class="fa-solid fa-chevron-up"></i>
        </button>
        <button onclick="scrollToNextVideo()" class="w-10 h-10 rounded-full bg-neutral-900 hover:bg-neutral-800 text-white flex items-center justify-center border border-neutral-800 shadow-xl transition">
            <i class="fa-solid fa-chevron-down"></i>
        </button>
    </div>

    <!-- TikTok Feed Viewport -->
    <div class="feed-viewport" id="feedViewport">
        @forelse($videos as $index => $video)
            <div class="feed-card py-6" id="video-card-{{ $index }}" data-index="{{ $index }}" data-video-id="{{ $video->id }}">
                
                <!-- Main Container: Video + Right Action Column -->
                <div class="relative flex items-end space-x-4 h-[92vh] max-h-[720px]">
                    
                    <!-- Vertical Phone Video Player Frame -->
                    <div class="relative h-full aspect-[9/16] bg-neutral-950 rounded-2xl overflow-hidden shadow-2xl border border-neutral-900 group"
                         ondblclick="handleDoubleTap(event, {{ $video->id }}, this)">
                        
                        <!-- Video Element -->
                        <video class="w-full h-full object-cover cursor-pointer video-element" loop playsinline muted preload="metadata" onclick="togglePlay(this)">
                            <source src="{{ $video->play_url }}" type="video/mp4">
                        </video>

                        <!-- Top Mute / Sound Icon Overlay -->
                        <button onclick="toggleAudio(this)" class="absolute top-4 left-4 z-30 w-8 h-8 rounded-full bg-black/40 text-white flex items-center justify-center backdrop-blur text-xs">
                            <i class="fa-solid fa-volume-xmark audio-icon"></i>
                        </button>

                        <!-- Center Play Icon Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-0 play-overlay transition-opacity duration-200">
                            <div class="w-16 h-16 rounded-full bg-black/60 text-white flex items-center justify-center text-2xl backdrop-blur">
                                <i class="fa-solid fa-play ml-1"></i>
                            </div>
                        </div>

                        <!-- Video Bottom Left Caption (Matching Screenshot caption style) -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 pb-5 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-auto z-20 space-y-1.5 text-left">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('profile.show', $video->user->id) }}" class="font-extrabold text-white text-base hover:underline drop-shadow">
                                    @ {{ $video->user->username }}
                                </a>
                                <span class="text-[10px] bg-white/20 text-white px-2 py-0.5 rounded-full font-bold">
                                    {{ ucfirst($video->user->role->name ?? 'User') }}
                                </span>
                            </div>

                            <p class="text-xs font-semibold text-white leading-relaxed drop-shadow line-clamp-2">
                                {{ $video->description ?: $video->title }}
                            </p>

                            <!-- Tagar -->
                            <div class="flex flex-wrap gap-1 pt-1">
                                @foreach($video->hashtags as $tag)
                                    <a href="{{ route('hashtag.show', $tag->name) }}" class="text-[11px] font-bold text-tiktok-cyan hover:underline">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Red Duration Scrubber Bar (Dari awal sampai akhir & bisa digeser) -->
                        <div class="video-scrubber-container absolute bottom-0 left-0 right-0 z-30 cursor-pointer h-4 flex items-end group/scrub select-none"
                             title="Geser durasi video">
                            <!-- Scrubber Track -->
                            <div class="w-full h-1 bg-white/25 group-hover/scrub:h-2 transition-all duration-150 relative">
                                <!-- Red Progress Bar Fill -->
                                <div class="scrubber-progress h-full bg-red-600 relative transition-none" style="width: 0%;">
                                    <!-- Scrubber Thumb Handle -->
                                    <div class="scrubber-thumb absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 w-3.5 h-3.5 rounded-full bg-red-600 border-2 border-white shadow-md opacity-0 group-hover/scrub:opacity-100 transition-opacity"></div>
                                </div>
                            </div>
                            <!-- Floating Time Tooltip -->
                            <div class="scrubber-tooltip absolute bottom-5 -translate-x-1/2 hidden px-2 py-0.5 rounded bg-black/90 text-[10px] text-white font-mono pointer-events-none z-40 border border-neutral-700 shadow-xl whitespace-nowrap">
                                00:00 / 00:00
                            </div>
                        </div>

                    </div>

                    <!-- Right Side Vertical Action Bar (Matching TikTok Screenshot) -->
                    <div class="flex flex-col space-y-4 pb-4 select-none">
                        
                        <!-- Creator Avatar + Red Plus Follow Badge -->
                        <div class="relative inline-block text-center">
                            <a href="{{ route('profile.show', $video->user->id) }}">
                                <img src="{{ $video->user->avatar_url }}" class="w-12 h-12 rounded-full border-2 border-neutral-800 object-cover shadow-xl">
                            </a>
                            @auth
                                @if(Auth::id() !== $video->user->id)
                                    <button onclick="toggleFollow({{ $video->user->id }}, this)" 
                                            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-5 h-5 rounded-full {{ Auth::user()->isFollowing($video->user->id) ? 'bg-neutral-800 text-white' : 'bg-tiktok-red text-white' }} flex items-center justify-center text-[10px] shadow-lg">
                                        <i class="fa-solid {{ Auth::user()->isFollowing($video->user->id) ? 'fa-check' : 'fa-plus' }}"></i>
                                    </button>
                                @endif
                            @endauth
                        </div>

                        <!-- Like Button (Heart) -->
                        <div class="text-center">
                            <button onclick="toggleLike({{ $video->id }}, this)" class="w-12 h-12 rounded-full bg-neutral-900/80 hover:bg-neutral-800 text-white flex items-center justify-center shadow-xl transition group">
                                <i class="fa-solid fa-heart text-2xl {{ (Auth::check() && Auth::user()->hasLiked($video->id)) ? 'text-tiktok-red' : 'text-white group-hover:text-tiktok-red' }} like-icon"></i>
                            </button>
                            <span class="text-[11px] font-bold text-neutral-300 mt-1 block like-count">{{ $video->likes_count > 999 ? round($video->likes_count/1000, 1).'K' : $video->likes_count }}</span>
                        </div>

                        <!-- Comment Button (Bubble) -->
                        <div class="text-center">
                            <button onclick="openCommentDrawer({{ $video->id }})" class="w-12 h-12 rounded-full bg-neutral-900/80 hover:bg-neutral-800 text-white flex items-center justify-center shadow-xl transition">
                                <i class="fa-solid fa-comment-dots text-2xl text-white"></i>
                            </button>
                            <span class="text-[11px] font-bold text-neutral-300 mt-1 block comment-count-{{ $video->id }}">{{ $video->comments_count }}</span>
                        </div>

                        <!-- Bookmark Button -->
                        <div class="text-center">
                            <button onclick="toggleBookmark(this)" class="w-12 h-12 rounded-full bg-neutral-900/80 hover:bg-neutral-800 text-white flex items-center justify-center shadow-xl transition">
                                <i class="fa-solid fa-bookmark text-xl text-white bookmark-icon"></i>
                            </button>
                            <span class="text-[11px] font-bold text-neutral-300 mt-1 block">57.4K</span>
                        </div>

                        <!-- Share Button -->
                        <div class="text-center">
                            <button onclick="shareVideo({{ $video->id }})" class="w-12 h-12 rounded-full bg-neutral-900/80 hover:bg-neutral-800 text-white flex items-center justify-center shadow-xl transition">
                                <i class="fa-solid fa-share text-xl text-white"></i>
                            </button>
                            <span class="text-[11px] font-bold text-neutral-300 mt-1 block share-count-{{ $video->id }}">{{ $video->shares_count }}</span>
                        </div>

                        <!-- Sound Disc Spinner -->
                        <div class="w-10 h-10 rounded-full bg-black p-1 border-2 border-neutral-700 mx-auto shadow-inner animate-disc-spin">
                            <img src="{{ $video->user->avatar_url }}" class="w-full h-full rounded-full object-cover">
                        </div>

                    </div>

                </div>

            </div>
        @empty
            <div class="h-full flex flex-col items-center justify-center text-neutral-400 space-y-3">
                <i class="fa-solid fa-film text-4xl text-neutral-700"></i>
                <p class="text-sm font-bold text-white">Belum ada video.</p>
                <a href="{{ route('video.upload') }}" class="px-6 py-2 rounded-full bg-tiktok-red text-white text-xs font-bold">
                    Unggah Video
                </a>
            </div>
        @endforelse
    </div>

</div>

<!-- Comment Drawer Modal -->
<div id="commentModal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex justify-end hidden">
    <div class="w-full max-w-md bg-neutral-900 h-full flex flex-col border-l border-neutral-800 shadow-2xl">
        <div class="p-4 border-b border-neutral-800 flex justify-between items-center">
            <h3 class="font-extrabold text-white text-sm flex items-center">
                <i class="fa-solid fa-comments text-tiktok-red mr-2"></i> Komentar Video
            </h3>
            <button onclick="closeCommentModal()" class="text-neutral-400 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div id="commentList" class="flex-1 overflow-y-auto p-4 space-y-3">
            <!-- Comments injected here -->
        </div>

        @auth
            <form id="commentForm" onsubmit="submitComment(event)" class="p-3 border-t border-neutral-800 flex space-x-2 bg-black">
                <input type="text" id="commentInput" placeholder="Tambahkan komentar..." required
                       class="flex-1 bg-neutral-900 border border-neutral-700 rounded-full px-4 py-2 text-xs text-white focus:outline-none focus:ring-2 focus:ring-tiktok-red">
                <button type="submit" class="px-5 py-2 rounded-full bg-tiktok-red text-white text-xs font-bold">
                    Kirim
                </button>
            </form>
        @else
            <div class="p-4 border-t border-neutral-800 text-center text-xs text-neutral-400">
                Silakan <a href="{{ route('login') }}" class="text-tiktok-red font-bold underline">Login</a> untuk berkomentar.
            </div>
        @endauth
    </div>
</div>
@endsection

@section('scripts')
<script>
    let activeVideoId = null;
    let currentCardIndex = 0;
    const totalCards = {{ count($videos) }};

    // IntersectionObserver to auto-play video
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const video = entry.target.querySelector('video');
            if (entry.isIntersecting) {
                currentCardIndex = parseInt(entry.target.getAttribute('data-index') || 0);
                video.play().catch(() => {});
            } else {
                video.pause();
            }
        });
    }, { threshold: 0.7 });

    document.querySelectorAll('.feed-card').forEach(card => {
        observer.observe(card);
    });

    function scrollToNextVideo() {
        if (currentCardIndex < totalCards - 1) {
            currentCardIndex++;
            const target = document.getElementById(`video-card-${currentCardIndex}`);
            if (target) target.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function scrollToPrevVideo() {
        if (currentCardIndex > 0) {
            currentCardIndex--;
            const target = document.getElementById(`video-card-${currentCardIndex}`);
            if (target) target.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function togglePlay(video) {
        const overlay = video.parentElement.querySelector('.play-overlay');
        if (video.paused) {
            video.play();
            overlay.classList.add('opacity-0');
        } else {
            video.pause();
            overlay.classList.remove('opacity-0');
        }
    }

    function toggleAudio(btn) {
        const video = btn.parentElement.querySelector('video');
        const icon = btn.querySelector('.audio-icon');
        video.muted = !video.muted;
        if (video.muted) {
            icon.className = 'fa-solid fa-volume-xmark audio-icon';
        } else {
            icon.className = 'fa-solid fa-volume-high text-tiktok-red audio-icon';
        }
    }

    function handleDoubleTap(e, videoId, container) {
        const heart = document.createElement('div');
        heart.className = 'heart-pop text-tiktok-red text-6xl shadow-2xl';
        heart.innerHTML = '<i class="fa-solid fa-heart"></i>';
        
        const rect = container.getBoundingClientRect();
        const x = e.clientX - rect.left - 30;
        const y = e.clientY - rect.top - 30;
        
        heart.style.left = x + 'px';
        heart.style.top = y + 'px';
        container.appendChild(heart);
        setTimeout(() => heart.remove(), 800);

        const card = document.getElementById(`video-card-${currentCardIndex}`);
        if (card) {
            const likeBtn = card.querySelector('.like-icon');
            if (likeBtn && !likeBtn.classList.contains('text-tiktok-red')) {
                toggleLike(videoId, likeBtn.parentElement);
            }
        }
    }

    function toggleLike(videoId, btn) {
        fetch(`/v/${videoId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const icon = btn.querySelector('.like-icon');
                const countEl = btn.nextElementSibling;
                if (data.liked) {
                    icon.classList.remove('text-white');
                    icon.classList.add('text-tiktok-red');
                } else {
                    icon.classList.remove('text-tiktok-red');
                    icon.classList.add('text-white');
                }
                countEl.textContent = data.likes_count;
            } else {
                alert(data.message || 'Silakan login.');
            }
        });
    }

    function toggleFollow(userId, btn) {
        fetch(`/u/${userId}/follow`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (data.following) {
                    btn.className = 'absolute -bottom-1 left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-neutral-800 text-white flex items-center justify-center text-[10px] shadow-lg';
                    btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                } else {
                    btn.className = 'absolute -bottom-1 left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-tiktok-red text-white flex items-center justify-center text-[10px] shadow-lg';
                    btn.innerHTML = '<i class="fa-solid fa-plus"></i>';
                }
            }
        });
    }

    function toggleBookmark(btn) {
        const icon = btn.querySelector('.bookmark-icon');
        icon.classList.toggle('text-amber-400');
    }

    function openCommentDrawer(videoId) {
        activeVideoId = videoId;
        document.getElementById('commentModal').classList.remove('hidden');
        
        fetch(`/v/${videoId}`)
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const comments = doc.querySelectorAll('.comment-item');
                const list = document.getElementById('commentList');
                list.innerHTML = '';
                if (comments.length === 0) {
                    list.innerHTML = '<p class="text-xs text-neutral-500 text-center py-6">Belum ada komentar.</p>';
                } else {
                    comments.forEach(c => list.appendChild(c.cloneNode(true)));
                }
            });
    }

    function closeCommentModal() {
        document.getElementById('commentModal').classList.add('hidden');
    }

    function submitComment(e) {
        e.preventDefault();
        const input = document.getElementById('commentInput');
        const content = input.value.trim();
        if (!content || !activeVideoId) return;

        fetch(`/v/${activeVideoId}/comment`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ content: content })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                openCommentDrawer(activeVideoId);
                const counter = document.querySelector(`.comment-count-${activeVideoId}`);
                if (counter) counter.textContent = data.comments_count;
            }
        });
    }

    function shareVideo(videoId) {
        fetch(`/v/${videoId}/share`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                navigator.clipboard.writeText(data.share_url);
                alert('Link video disalin ke clipboard! Total Share: ' + data.shares_count);
                const counter = document.querySelector(`.share-count-${videoId}`);
                if (counter) counter.textContent = data.shares_count;
            }
        });
    }

    // --- Video Scrubber (Batang Durasi Merah & Drag Seek) ---
    function formatTime(seconds) {
        if (isNaN(seconds) || seconds < 0) return '00:00';
        const m = Math.floor(seconds / 60);
        const s = Math.floor(seconds % 60);
        return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }

    function initVideoScrubbers() {
        document.querySelectorAll('.feed-card').forEach(card => {
            const video = card.querySelector('video');
            const scrubberContainer = card.querySelector('.video-scrubber-container');
            if (!video || !scrubberContainer) return;

            const progressBar = scrubberContainer.querySelector('.scrubber-progress');
            const tooltip = scrubberContainer.querySelector('.scrubber-tooltip');
            let isDragging = false;
            let wasPlayingBeforeDrag = false;

            // Fix Chrome WebM infinite duration issue and adapt landscape videos
            video.addEventListener('loadedmetadata', () => {
                if (video.videoWidth && video.videoHeight && video.videoWidth > video.videoHeight) {
                    video.classList.remove('object-cover');
                    video.classList.add('object-contain');
                }
                if (video.duration === Infinity || isNaN(video.duration)) {
                    video.currentTime = 1e101;
                    video.ontimeupdate = function() {
                        this.ontimeupdate = null;
                        this.currentTime = 0;
                    };
                }
            });

            // Update progress bar as video plays
            video.addEventListener('timeupdate', () => {
                if (!isDragging && video.duration && !isNaN(video.duration)) {
                    const percent = (video.currentTime / video.duration) * 100;
                    progressBar.style.width = `${percent}%`;
                }
            });

            function seekToPosition(clientX) {
                const rect = scrubberContainer.getBoundingClientRect();
                const pos = Math.max(0, Math.min(clientX - rect.left, rect.width));
                const percentage = pos / rect.width;
                progressBar.style.width = `${percentage * 100}%`;

                if (video.duration && !isNaN(video.duration)) {
                    video.currentTime = percentage * video.duration;
                }

                if (tooltip) {
                    tooltip.style.left = `${pos}px`;
                    tooltip.classList.remove('hidden');
                    tooltip.textContent = `${formatTime(video.currentTime)} / ${formatTime(video.duration || 0)}`;
                }
            }

            // Mouse scrub events
            scrubberContainer.addEventListener('mousedown', (e) => {
                e.stopPropagation();
                e.preventDefault();
                isDragging = true;
                wasPlayingBeforeDrag = !video.paused;
                seekToPosition(e.clientX);

                function onMouseMove(moveEvent) {
                    if (!isDragging) return;
                    moveEvent.preventDefault();
                    seekToPosition(moveEvent.clientX);
                }

                function onMouseUp() {
                    if (!isDragging) return;
                    isDragging = false;
                    window.removeEventListener('mousemove', onMouseMove);
                    window.removeEventListener('mouseup', onMouseUp);
                    if (tooltip) tooltip.classList.add('hidden');
                    if (wasPlayingBeforeDrag && video.paused) {
                        video.play().catch(() => {});
                    }
                }

                window.addEventListener('mousemove', onMouseMove);
                window.addEventListener('mouseup', onMouseUp);
            });

            // Touch scrub events
            scrubberContainer.addEventListener('touchstart', (e) => {
                e.stopPropagation();
                if (e.touches.length === 0) return;
                isDragging = true;
                wasPlayingBeforeDrag = !video.paused;
                seekToPosition(e.touches[0].clientX);

                function onTouchMove(moveEvent) {
                    if (!isDragging || moveEvent.touches.length === 0) return;
                    seekToPosition(moveEvent.touches[0].clientX);
                }

                function onTouchEnd() {
                    if (!isDragging) return;
                    isDragging = false;
                    window.removeEventListener('touchmove', onTouchMove);
                    window.removeEventListener('touchend', onTouchEnd);
                    if (tooltip) tooltip.classList.add('hidden');
                    if (wasPlayingBeforeDrag && video.paused) {
                        video.play().catch(() => {});
                    }
                }

                window.addEventListener('touchmove', onTouchMove, { passive: true });
                window.addEventListener('touchend', onTouchEnd);
            }, { passive: true });

            // Hover tooltip
            scrubberContainer.addEventListener('mousemove', (e) => {
                if (isDragging) return;
                const rect = scrubberContainer.getBoundingClientRect();
                const pos = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
                const percentage = pos / rect.width;
                const previewTime = (video.duration || 0) * percentage;
                if (tooltip) {
                    tooltip.style.left = `${pos}px`;
                    tooltip.classList.remove('hidden');
                    tooltip.textContent = `${formatTime(previewTime)} / ${formatTime(video.duration || 0)}`;
                }
            });

            scrubberContainer.addEventListener('mouseleave', () => {
                if (!isDragging && tooltip) {
                    tooltip.classList.add('hidden');
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initVideoScrubbers);
    initVideoScrubbers();
</script>
@endsection
