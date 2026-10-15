@extends('layouts.app')

@section('title', $video->title . ' - SchoolVideo')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 w-full flex-1">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Main Video Player & Details -->
            <div class="lg:col-span-8 space-y-5">

                <!-- Video Player Container (Landscape adaptive & no forced overflow) -->
                <div id="videoContainer" class="relative w-full max-h-[72vh] min-h-[260px] rounded-3xl overflow-hidden bg-black shadow-2xl border border-slate-800 flex items-center justify-center group transition-all duration-300">
                    <video id="mainVideoPlayer" class="w-full h-auto max-h-[72vh] object-contain block mx-auto" controls autoplay playsinline preload="auto">
                        <source src="{{ $video->play_url }}" type="video/mp4">
                        Browser Anda tidak mendukung video.
                    </video>

                    <!-- Floating Skip Animations (Ripple Indicator) -->
                    <div id="skipRippleLeft" class="absolute left-6 top-1/2 -translate-y-1/2 bg-black/70 backdrop-blur-md text-white px-4 py-3 rounded-2xl flex flex-col items-center pointer-events-none opacity-0 scale-75 transition-all duration-200 z-20 border border-slate-700/60 shadow-2xl">
                        <i class="fa-solid fa-backward text-2xl text-brand-400"></i>
                        <span class="text-xs font-bold mt-1">-<span class="skip-val-text">10</span>s</span>
                    </div>
                    <div id="skipRippleRight" class="absolute right-6 top-1/2 -translate-y-1/2 bg-black/70 backdrop-blur-md text-white px-4 py-3 rounded-2xl flex flex-col items-center pointer-events-none opacity-0 scale-75 transition-all duration-200 z-20 border border-slate-700/60 shadow-2xl">
                        <i class="fa-solid fa-forward text-2xl text-brand-400"></i>
                        <span class="text-xs font-bold mt-1">+<span class="skip-val-text">10</span>s</span>
                    </div>
                </div>

                <!-- Interactive Video Control & Skip Bar with 3-Dots Menu -->
                <div class="glass-card px-4 sm:px-6 py-3 rounded-2xl flex items-center justify-between gap-3 text-xs border border-slate-800/80 shadow-lg">
                    <div class="flex items-center space-x-2">
                        <!-- Rewind / Skip Back -->
                        <button type="button" onclick="performVideoSkip(-1)" title="Lompat mundur" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold flex items-center space-x-1.5 transition">
                            <i class="fa-solid fa-rotate-left text-sm text-brand-400"></i>
                            <span>-<span class="skip-val-text">10</span>s</span>
                        </button>

                        <!-- Play / Pause Button -->
                        <button type="button" onclick="toggleMainVideoPlay()" id="btnPlayPause" title="Play/Pause" class="px-3.5 py-1.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-bold flex items-center space-x-1.5 transition">
                            <i class="fa-solid fa-pause text-xs" id="iconPlayPause"></i>
                            <span id="textPlayPause">Jeda</span>
                        </button>

                        <!-- Fast Forward / Skip Forward -->
                        <button type="button" onclick="performVideoSkip(1)" title="Lompat maju" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold flex items-center space-x-1.5 transition">
                            <span>+<span class="skip-val-text">10</span>s</span>
                            <i class="fa-solid fa-rotate-right text-sm text-brand-400"></i>
                        </button>
                    </div>

                    <!-- Right Controls: Keyboard hint & 3-Dots Settings Menu -->
                    <div class="flex items-center space-x-3 relative">
                        <span class="hidden md:inline-block text-[11px] text-slate-400">
                            <i class="fa-regular fa-keyboard mr-1"></i> Gunakan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-white font-mono text-[10px] border border-slate-700">←</kbd> <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-white font-mono text-[10px] border border-slate-700">→</kbd>
                        </span>

                        <!-- 3-Dots Menu Button (Titik Tiga di bawah video) -->
                        <div class="relative" id="skipSettingsMenuContainer">
                            <button type="button" id="btnThreeDots" onclick="toggleSkipSettingsMenu(event)" title="Pengaturan Skip Video" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition border border-slate-700">
                                <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                            </button>

                            <!-- 3-Dots Dropdown Popup: Settings 5, 10, 15, 20, 30 -->
                            <div id="skipSettingsDropdown" class="hidden absolute right-0 bottom-full mb-2 w-64 bg-[#1f1f23] border border-slate-700/80 rounded-2xl shadow-2xl p-3 z-50 divide-y divide-slate-800 text-left backdrop-blur-md animate-in fade-in zoom-in-95 duration-150">
                                <div class="pb-2">
                                    <p class="font-extrabold text-white text-xs flex items-center">
                                        <i class="fa-solid fa-sliders text-brand-400 mr-2"></i> Pengaturan Lompatan (Skip)
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5 leading-snug">Pilih durasi lompat saat tombol atau panah keyboard ditekan:</p>
                                </div>
                                <div class="py-2 space-y-1">
                                    @foreach([5, 10, 15, 20, 30] as $sec)
                                        <button type="button" onclick="setSkipDuration({{ $sec }})" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-white transition group skip-opt-btn" data-sec="{{ $sec }}">
                                            <span class="flex items-center space-x-2">
                                                <i class="fa-regular fa-clock text-slate-400 group-hover:text-brand-400"></i>
                                                <span>{{ $sec }} Detik</span>
                                            </span>
                                            <span class="check-icon text-brand-400 text-xs hidden"><i class="fa-solid fa-check"></i></span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Title & Engagement Actions Bar -->
                <div class="glass-card p-6 rounded-3xl space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="space-y-1 max-w-2xl">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-brand-500/10 text-brand-400 border border-brand-500/20">
                                {{ $video->category->name ?? 'Umum' }}
                            </span>
                            <h1 class="text-xl sm:text-2xl font-extrabold text-white leading-snug">{{ $video->title }}</h1>
                            <p class="text-xs text-slate-400">Diunggah {{ $video->created_at->diffForHumans() }} •
                                {{ number_format($video->views_count) }} Penayangan</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3">
                            <button onclick="toggleLikeDetails({{ $video->id }}, this)"
                                class="px-4 py-2 rounded-full bg-slate-800 hover:bg-slate-700 text-xs font-bold text-white flex items-center space-x-1.5 transition">
                                <i
                                    class="fa-solid fa-heart text-base {{ (Auth::check() && Auth::user()->hasLiked($video->id)) ? 'text-red-500' : 'text-slate-400' }} detail-like-icon"></i>
                                <span class="detail-like-count">{{ $video->likes_count }}</span>
                            </button>

                            <button onclick="shareVideo({{ $video->id }})"
                                class="px-4 py-2 rounded-full bg-slate-800 hover:bg-slate-700 text-xs font-bold text-white flex items-center space-x-1.5 transition">
                                <i class="fa-solid fa-share text-base text-slate-400"></i>
                                <span class="detail-share-count">{{ $video->shares_count }}</span>
                            </button>

                            @auth
                                @if(Auth::id() === $video->user_id || Auth::user()->isGuru())
                                    <a href="{{ route('video.edit', $video->id) }}"
                                        class="px-3 py-2 rounded-full bg-slate-800 hover:bg-slate-700 text-xs font-bold text-amber-400">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('video.destroy', $video->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-2 rounded-full bg-red-500/20 hover:bg-red-500/30 text-xs font-bold text-red-400">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Creator Bar -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('profile.show', $video->user->id) }}">
                                <img src="{{ $video->user->avatar_url }}"
                                    class="w-12 h-12 rounded-full object-cover border-2 border-brand-500">
                            </a>
                            <div>
                                <a href="{{ route('profile.show', $video->user->id) }}"
                                    class="font-extrabold text-white text-sm hover:underline">
                                    {{ $video->user->name }}
                                </a>
                                <p class="text-xs text-slate-400">@ {{ $video->user->username }} •
                                    {{ ucfirst($video->user->role->name ?? 'User') }}</p>
                            </div>
                        </div>

                        @auth
                            @if(Auth::id() !== $video->user->id)
                                <button onclick="toggleFollowDetails({{ $video->user->id }}, this)"
                                    class="px-5 py-2 rounded-full text-xs font-bold text-white transition {{ Auth::user()->isFollowing($video->user->id) ? 'bg-slate-800 hover:bg-slate-700' : 'bg-brand-600 hover:bg-brand-500' }}">
                                    {{ Auth::user()->isFollowing($video->user->id) ? 'Mengikuti' : '+ Ikuti' }}
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 rounded-full text-xs font-bold text-white transition bg-brand-600 hover:bg-brand-500">
                                + Ikuti
                            </a>
                        @endauth
                    </div>

                    <!-- Description & Hashtags -->
                    <div class="pt-2 text-xs text-slate-300 leading-relaxed space-y-2">
                        <p>{{ $video->description }}</p>
                        <div class="flex flex-wrap gap-1.5 pt-2">
                            @foreach($video->hashtags as $tag)
                                <a href="{{ route('hashtag.show', $tag->name) }}"
                                    class="text-brand-400 hover:underline font-bold">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="glass-card p-6 rounded-3xl space-y-4">
                    <h3 class="text-base font-bold text-white flex items-center">
                        <i class="fa-solid fa-comments text-brand-400 mr-2"></i> Komentar (<span id="commentsCountBadge">{{ $video->comments_count }}</span>)
                    </h3>

                    @auth
                        <form id="commentFormDetail" onsubmit="submitCommentDetail(event)" action="{{ route('video.comment', $video->id) }}" method="POST" class="flex space-x-3">
                            @csrf
                            <input type="text" id="commentInputDetail" name="content" required placeholder="Tulis komentar publik..."
                                class="flex-1 bg-slate-900 border border-slate-700 rounded-full px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <button type="submit" id="btnSubmitComment"
                                class="px-6 py-2.5 rounded-full bg-brand-600 hover:bg-brand-500 text-white font-bold text-xs flex items-center space-x-1.5 transition">
                                <span>Kirim</span>
                            </button>
                        </form>
                    @else
                        <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 text-xs text-slate-400 text-center">
                            Silakan <a href="{{ route('login') }}" class="text-brand-400 font-bold underline">Login</a> untuk memberikan komentar publik.
                        </div>
                    @endauth

                    <div id="commentListContainer" class="space-y-3 pt-2">
                        @forelse($video->comments as $comment)
                            <div
                                class="p-3 rounded-2xl bg-slate-900/60 border border-slate-800/80 flex items-start justify-between comment-item transition">
                                <div class="flex space-x-3">
                                    <a href="{{ route('profile.show', $comment->user->id) }}">
                                        <img src="{{ $comment->user->avatar_url }}"
                                            class="w-8 h-8 rounded-full object-cover mt-0.5 border border-slate-700">
                                    </a>
                                    <div class="space-y-0.5">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('profile.show', $comment->user->id) }}"
                                                class="font-bold text-white text-xs hover:underline">
                                                {{ $comment->user->name }}
                                            </a>
                                            <span
                                                class="text-[10px] text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-xs text-slate-300">{{ $comment->content }}</p>
                                    </div>
                                </div>
                                @auth
                                    @if(Auth::id() === $comment->user_id || Auth::user()->isGuru())
                                        <form action="{{ route('comment.delete', $comment->id) }}" method="POST" onsubmit="deleteCommentDetail(event, {{ $comment->id }}, this)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-500 hover:text-red-400 text-xs p-1 transition" title="Hapus komentar">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        @empty
                            <p id="emptyCommentsNotice" class="text-xs text-slate-500 text-center py-4">Belum ada komentar pada video ini.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Sidebar Related Videos (Saran Video di Kanan) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="glass-card p-6 rounded-3xl space-y-4">
                    <h3 class="text-sm font-bold text-white flex items-center">
                        <i class="fa-solid fa-circle-play text-accent-pink mr-2"></i> Video Terkait
                    </h3>

                    <div class="space-y-3">
                        @foreach($relatedVideos as $rel)
                            <div class="flex space-x-3 p-2 rounded-2xl hover:bg-slate-900/60 transition group border border-transparent hover:border-slate-800/80">
                                <!-- Thumbnail Link to Video -->
                                <a href="{{ route('video.show', $rel->id) }}" class="relative w-28 aspect-video rounded-xl overflow-hidden bg-slate-950 flex-shrink-0 block shadow">
                                    <img src="{{ $rel->thumbnail_url }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-black/80 text-[9px] font-mono font-bold text-white">
                                        {{ sprintf('%02d:%02d', floor($rel->duration / 60), $rel->duration % 60) }}
                                    </span>
                                </a>

                                <!-- Info Container -->
                                <div class="flex-1 space-y-1 min-w-0">
                                    <a href="{{ route('video.show', $rel->id) }}" class="text-xs font-bold text-white line-clamp-2 hover:text-brand-400 transition block">
                                        {{ $rel->title }}
                                    </a>

                                    <!-- Separate Clickable Creator Area: Direct to Profile -->
                                    <div>
                                        <a href="{{ route('profile.show', $rel->user->id) }}"
                                           class="inline-flex items-center space-x-1.5 text-[11px] font-medium text-slate-300 hover:text-brand-400 hover:underline transition max-w-full truncate"
                                           title="Buka profil {{ $rel->user->name }}">
                                            <i class="fa-solid fa-circle-user text-[10px] text-brand-400"></i>
                                            <span class="truncate font-semibold">{{ $rel->user->name }}</span>
                                        </a>
                                    </div>

                                    <p class="text-[10px] text-slate-500">
                                        <i class="fa-solid fa-eye mr-1"></i>{{ number_format($rel->views_count) }} views
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // --- 1. Notification Toast ---
        function showToastNotification(msg) {
            let toast = document.getElementById('globalToast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'globalToast';
                toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-5 py-2.5 rounded-full bg-slate-900/95 border border-brand-500/50 text-white text-xs font-bold shadow-2xl backdrop-blur flex items-center space-x-2 transition-all duration-300 opacity-0 pointer-events-none translate-y-4';
                document.body.appendChild(toast);
            }
            toast.innerHTML = `<i class="fa-solid fa-circle-check text-emerald-400"></i> <span>${msg}</span>`;
            toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
            }, 2500);
        }

        // --- 2. Skip Duration Settings System (5, 10, 15, 20, 30s) ---
        let currentSkipDuration = parseInt(localStorage.getItem('schoolvideo_skip_seconds')) || 10;
        if (![5, 10, 15, 20, 30].includes(currentSkipDuration)) {
            currentSkipDuration = 10;
        }

        function updateSkipDisplay() {
            document.querySelectorAll('.skip-val-text').forEach(el => el.textContent = currentSkipDuration);
            document.querySelectorAll('.skip-opt-btn').forEach(btn => {
                const sec = parseInt(btn.getAttribute('data-sec'));
                const check = btn.querySelector('.check-icon');
                if (sec === currentSkipDuration) {
                    btn.classList.add('bg-slate-800', 'text-white', 'font-bold');
                    if (check) check.classList.remove('hidden');
                } else {
                    btn.classList.remove('bg-slate-800', 'text-white', 'font-bold');
                    if (check) check.classList.add('hidden');
                }
            });
        }

        function setSkipDuration(sec) {
            currentSkipDuration = sec;
            localStorage.setItem('schoolvideo_skip_seconds', sec);
            updateSkipDisplay();
            const dropdown = document.getElementById('skipSettingsDropdown');
            if (dropdown) dropdown.classList.add('hidden');
            showToastNotification(`Durasi lompat diatur ke ${sec} detik.`);
        }

        function toggleSkipSettingsMenu(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('skipSettingsDropdown');
            if (dropdown) dropdown.classList.toggle('hidden');
        }

        document.addEventListener('click', function (e) {
            const container = document.getElementById('skipSettingsMenuContainer');
            const dropdown = document.getElementById('skipSettingsDropdown');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                if (!container || !container.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });

        function performVideoSkip(direction) {
            const player = document.getElementById('mainVideoPlayer');
            if (!player) return;

            const delta = direction * currentSkipDuration;
            const target = Math.max(0, Math.min(player.duration || 0, player.currentTime + delta));
            player.currentTime = target;

            // Trigger ripple indicator animation
            const ripple = direction > 0 ? document.getElementById('skipRippleRight') : document.getElementById('skipRippleLeft');
            if (ripple) {
                ripple.classList.remove('opacity-0', 'scale-75');
                ripple.classList.add('opacity-100', 'scale-100');
                setTimeout(() => {
                    ripple.classList.remove('opacity-100', 'scale-100');
                    ripple.classList.add('opacity-0', 'scale-75');
                }, 600);
            }
        }

        function toggleMainVideoPlay() {
            const player = document.getElementById('mainVideoPlayer');
            if (!player) return;
            if (player.paused) {
                player.play();
            } else {
                player.pause();
            }
        }

        // --- 3. Like Details Function ---
        function toggleLikeDetails(videoId, btn) {
            fetch(`/v/${videoId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                return res.json();
            })
            .then(data => {
                if (data && data.success) {
                    const icon = btn.querySelector('.detail-like-icon');
                    const count = btn.querySelector('.detail-like-count');
                    if (data.liked) {
                        icon.classList.remove('text-slate-400');
                        icon.classList.add('text-red-500');
                        btn.classList.add('scale-105');
                        setTimeout(() => btn.classList.remove('scale-105'), 200);
                    } else {
                        icon.classList.remove('text-red-500');
                        icon.classList.add('text-slate-400');
                    }
                    if (count) count.textContent = data.likes_count;
                }
            })
            .catch(() => {
                showToastNotification('Gagal menyukai video.');
            });
        }

        // --- 4. Share Video Function ---
        function shareVideo(videoId) {
            fetch(`/v/${videoId}/share`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const shareUrl = data.share_url || window.location.href;
                navigator.clipboard.writeText(shareUrl).then(() => {
                    showToastNotification('Link video berhasil disalin ke clipboard!');
                }).catch(() => {
                    prompt('Salin link video:', shareUrl);
                });

                const countEl = document.querySelector('.detail-share-count');
                if (countEl && data.shares_count !== undefined) {
                    countEl.textContent = data.shares_count;
                }
            })
            .catch(() => {
                navigator.clipboard.writeText(window.location.href);
                showToastNotification('Link video berhasil disalin ke clipboard!');
            });
        }

        // --- 5. Follow User Function ---
        function toggleFollowDetails(userId, btn) {
            fetch(`/u/${userId}/follow`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                return res.json();
            })
            .then(data => {
                if (data && data.success) {
                    if (data.following) {
                        btn.textContent = 'Mengikuti';
                        btn.className = 'px-5 py-2 rounded-full text-xs font-bold text-white transition bg-slate-800 hover:bg-slate-700';
                    } else {
                        btn.textContent = '+ Ikuti';
                        btn.className = 'px-5 py-2 rounded-full text-xs font-bold text-white transition bg-brand-600 hover:bg-brand-500';
                    }
                }
            })
            .catch(() => {
                showToastNotification('Gagal mengubah status mengikuti.');
            });
        }

        // --- 6. Comment Submission with Dynamic In-Page Update ---
        function submitCommentDetail(e) {
            e.preventDefault();
            const input = document.getElementById('commentInputDetail');
            const content = input.value.trim();
            if (!content) return;

            const btn = document.getElementById('btnSubmitComment');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

            fetch('{{ route("video.comment", $video->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ content: content })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<span>Kirim</span>';
                if (data.success) {
                    input.value = '';
                    const container = document.getElementById('commentListContainer');
                    const emptyNotice = document.getElementById('emptyCommentsNotice');
                    if (emptyNotice) emptyNotice.remove();

                    const item = document.createElement('div');
                    item.className = 'p-3 rounded-2xl bg-slate-900/80 border border-brand-500/30 flex items-start justify-between comment-item transition animate-in fade-in duration-300';
                    item.innerHTML = `
                        <div class="flex space-x-3">
                            <a href="/u/{{ Auth::id() }}">
                                <img src="${data.comment.avatar_url}" class="w-8 h-8 rounded-full object-cover mt-0.5 border border-slate-700">
                            </a>
                            <div class="space-y-0.5">
                                <div class="flex items-center space-x-2">
                                    <a href="/u/{{ Auth::id() }}" class="font-bold text-white text-xs hover:underline">
                                        ${data.comment.user_name}
                                    </a>
                                    <span class="text-[10px] text-slate-500">${data.comment.time_ago}</span>
                                </div>
                                <p class="text-xs text-slate-300">${data.comment.content}</p>
                            </div>
                        </div>
                    `;
                    container.insertBefore(item, container.firstChild);

                    const badge = document.getElementById('commentsCountBadge');
                    if (badge) badge.textContent = data.comments_count;

                    showToastNotification('Komentar berhasil dipublikasikan!');
                } else {
                    alert(data.message || 'Gagal mengirim komentar.');
                }
            })
            .catch(() => {
                document.getElementById('commentFormDetail').submit();
            });
        }

        function deleteCommentDetail(e, commentId, form) {
            e.preventDefault();
            if (!confirm('Apakah Anda yakin ingin menghapus komentar ini?')) return;

            fetch(`/comment/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const row = form.closest('.comment-item');
                    if (row) row.remove();
                    const badge = document.getElementById('commentsCountBadge');
                    if (badge) {
                        const cur = parseInt(badge.textContent) || 1;
                        badge.textContent = Math.max(0, cur - 1);
                    }
                    showToastNotification('Komentar berhasil dihapus.');
                }
            });
        }

        // --- 7. Video Setup, Landscape Aspect Ratio & Keyboard Shortcuts ---
        const player = document.getElementById('mainVideoPlayer');
        if (player) {
            player.addEventListener('play', () => {
                const text = document.getElementById('textPlayPause');
                const icon = document.getElementById('iconPlayPause');
                if (text) text.textContent = 'Jeda';
                if (icon) icon.className = 'fa-solid fa-pause text-xs';
            });

            player.addEventListener('pause', () => {
                const text = document.getElementById('textPlayPause');
                const icon = document.getElementById('iconPlayPause');
                if (text) text.textContent = 'Putar';
                if (icon) icon.className = 'fa-solid fa-play text-xs';
            });

            // Dynamic Landscape Video Fitting (No forced overflow)
            player.addEventListener('loadedmetadata', function () {
                if (player.videoWidth && player.videoHeight) {
                    const aspect = player.videoWidth / player.videoHeight;
                    const container = document.getElementById('videoContainer');
                    if (container && aspect > 1) {
                        container.style.aspectRatio = `${player.videoWidth} / ${player.videoHeight}`;
                        container.style.maxHeight = '72vh';
                    }
                }
                if (player.duration === Infinity || isNaN(player.duration)) {
                    player.currentTime = 1e101;
                    player.ontimeupdate = function () {
                        this.ontimeupdate = null;
                        this.currentTime = 0;
                    };
                }
            });

            // Keyboard navigation for video scrubbing / seeking
            window.addEventListener('keydown', function (e) {
                if (['input', 'textarea'].includes(document.activeElement.tagName.toLowerCase())) return;
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    performVideoSkip(-1);
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    performVideoSkip(1);
                } else if (e.key === ' ' && document.activeElement !== player) {
                    e.preventDefault();
                    toggleMainVideoPlay();
                }
            });
        }

        // Initialize displays on load
        document.addEventListener('DOMContentLoaded', () => {
            updateSkipDisplay();
        });
        updateSkipDisplay();
    </script>
@endsection