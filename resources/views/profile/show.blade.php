@extends('layouts.app')

@section('title', $user->name . ' (@' . $user->username . ') • Instagram Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10 w-full flex-1 space-y-8 select-none">
    
    <!-- Instagram Style Profile Header Section -->
    <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-6 sm:space-y-0 sm:space-x-12 px-4">
        
        <!-- Avatar Column with "Catatan..." Tooltip -->
        <div class="relative flex flex-col items-center flex-shrink-0">
            <!-- Speech bubble tooltip over avatar (Catatan...) -->
            <div class="absolute -top-6 bg-neutral-800 text-[10px] text-neutral-300 font-bold px-3 py-1 rounded-full border border-neutral-700 shadow-md flex items-center space-x-1 z-10 animate-bounce">
                <span>Catatan...</span>
            </div>

            <!-- Avatar Circle -->
            <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full p-1 bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 shadow-2xl">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->username }}" class="w-full h-full rounded-full object-cover border-4 border-black">
            </div>
        </div>

        <!-- Details Column -->
        <div class="flex-1 space-y-4 text-center sm:text-left">
            
            <!-- Row 1: Username & Settings Icon -->
            <div class="flex items-center justify-center sm:justify-start space-x-4">
                <h1 class="text-xl font-bold text-white tracking-tight">{{ $user->username }}</h1>
                
                @auth
                    @if(Auth::id() === $user->id)
                        <div class="relative inline-block text-left" id="settings-menu-container">
                            <button type="button" id="settings-btn" onclick="toggleSettingsMenu(event)" title="Pengaturan profil" class="text-white hover:text-neutral-300 transition p-1 rounded-lg hover:bg-neutral-800/80 focus:outline-none">
                                <i class="fa-solid fa-gear text-lg"></i>
                            </button>

                            <!-- Instagram Style Popup Navbar Dropdown -->
                            <div id="settings-dropdown" class="hidden absolute left-1/2 -translate-x-1/2 sm:left-0 sm:translate-x-0 mt-2 w-52 bg-[#262626] border border-neutral-700/80 rounded-2xl shadow-2xl z-50 overflow-hidden divide-y divide-neutral-700/60 backdrop-blur-sm animate-in fade-in zoom-in-95 duration-150">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 text-xs font-semibold text-neutral-100 hover:bg-neutral-700/60 transition group">
                                        <i class="fa-solid fa-pen-to-square text-sm text-neutral-400 group-hover:text-white transition w-5 text-center"></i>
                                        <span>Edit Profile</span>
                                    </a>
                                </div>
                                <div class="py-1">
                                    <form id="profile-logout-form" action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-xs font-semibold text-red-500 hover:bg-neutral-700/60 hover:text-red-400 transition group text-left">
                                            <i class="fa-solid fa-arrow-right-from-bracket text-sm text-red-500 group-hover:text-red-400 transition w-5 text-center"></i>
                                            <span>Log Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Row 2: Stats Row (5 kiriman  35 pengikut  78 diikuti) -->
            <div class="flex items-center justify-center sm:justify-start space-x-8 text-sm text-neutral-200">
                <div><span class="font-bold text-white">{{ count($videos) }}</span> kiriman</div>
                <div><span class="font-bold text-white">{{ $followersCount }}</span> pengikut</div>
                <div><span class="font-bold text-white">{{ $followingCount }}</span> diikuti</div>
            </div>

            <!-- Row 3: Name Handle & Bio -->
            <div class="space-y-1 text-xs">
                <p class="font-bold text-white flex items-center justify-center sm:justify-start">
                    <i class="fa-solid fa-at text-neutral-500 mr-0.5"></i>{{ $user->username }}
                    @if($user->student)
                        <span class="ml-2 text-[10px] bg-neutral-800 text-neutral-300 px-2 py-0.5 rounded-md font-semibold">
                            {{ $user->student->schoolClass->name ?? 'XI PPLG' }}
                        </span>
                    @endif
                </p>
                <p class="text-neutral-300 whitespace-pre-line leading-relaxed max-w-md">
                    {{ $user->profile->bio ?? 'Belum ada bio profil.' }}
                </p>
            </div>

            <!-- Row 4: Action Buttons (Edit profil | Lihat arsip) -->
            <div class="flex items-center justify-center sm:justify-start gap-3 pt-2">
                @auth
                    @if(Auth::id() === $user->id)
                        <a href="{{ route('profile.edit') }}" class="flex-1 sm:flex-none px-8 py-2 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white font-bold text-xs transition text-center">
                            Edit profil
                        </a>
                        <a href="{{ route('feed') }}" class="flex-1 sm:flex-none px-8 py-2 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white font-bold text-xs transition text-center">
                            Lihat arsip
                        </a>
                    @else
                        <button onclick="toggleFollowProfile({{ $user->id }}, this)" 
                                class="flex-1 sm:flex-none px-8 py-2 rounded-xl font-bold text-xs text-white transition text-center {{ Auth::user()->isFollowing($user->id) ? 'bg-neutral-800 hover:bg-neutral-700' : 'bg-tiktok-red hover:opacity-90' }}">
                            {{ Auth::user()->isFollowing($user->id) ? 'Mengikuti' : '+ Ikuti' }}
                        </button>
                    @endif
                @endauth
            </div>

        </div>

    </div>

    <!-- Instagram Story Highlights Row (Circle + Baru) -->
    <div class="px-4 border-t border-neutral-900 pt-6">
        <div class="flex items-center space-x-6 overflow-x-auto pb-2">
            <div class="flex flex-col items-center space-y-1.5 cursor-pointer group">
                <div class="w-16 h-16 rounded-full bg-neutral-900 border border-neutral-800 group-hover:border-neutral-600 flex items-center justify-center text-white text-xl transition shadow">
                    <i class="fa-solid fa-plus text-neutral-400 group-hover:text-white"></i>
                </div>
                <span class="text-[11px] font-semibold text-neutral-400">Baru</span>
            </div>
        </div>
    </div>

    <!-- Instagram Navigation Tabs (Grid | Reels | Saved | Tagged) -->
    <div class="border-t border-neutral-900">
        <div class="flex justify-center space-x-12 text-xs font-bold uppercase tracking-wider text-neutral-500">
            <button onclick="switchTab('posts')" id="tab-posts" class="py-3 flex items-center space-x-2 border-b-2 border-white text-white">
                <i class="fa-solid fa-table-cells text-sm"></i>
                <span class="hidden sm:inline">Postingan</span>
            </button>
            <button onclick="switchTab('reels')" id="tab-reels" class="py-3 flex items-center space-x-2 border-b-2 border-transparent hover:text-white">
                <i class="fa-solid fa-[#000] fa-clapperboard text-sm"></i>
                <span class="hidden sm:inline">Reels</span>
            </button>
            <button onclick="switchTab('saved')" id="tab-saved" class="py-3 flex items-center space-x-2 border-b-2 border-transparent hover:text-white">
                <i class="fa-solid fa-bookmark text-sm"></i>
                <span class="hidden sm:inline">Tersimpan</span>
            </button>
            <button onclick="switchTab('tagged')" id="tab-tagged" class="py-3 flex items-center space-x-2 border-b-2 border-transparent hover:text-white">
                <i class="fa-solid fa-user-tag text-sm"></i>
                <span class="hidden sm:inline">Ditandai</span>
            </button>
        </div>
    </div>

    <!-- Grid Section of Video Posts -->
    <div id="posts-content" class="grid grid-cols-3 gap-1 sm:gap-2">
        @forelse($videos as $video)
            <a href="{{ route('video.show', $video->id) }}" class="relative aspect-square bg-neutral-900 overflow-hidden group cursor-pointer">
                <img src="{{ $video->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                
                <!-- Reel Camera Icon Top Right -->
                <div class="absolute top-2 right-2 text-white drop-shadow text-xs">
                    <i class="fa-solid fa-clapperboard"></i>
                </div>

                <!-- Hover Overlay Stats (Likes & Comments) -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-6 text-white font-bold text-sm">
                    <span class="flex items-center"><i class="fa-solid fa-heart mr-1.5 text-tiktok-red"></i>{{ $video->likes_count }}</span>
                    <span class="flex items-center"><i class="fa-solid fa-comment mr-1.5"></i>{{ $video->comments_count }}</span>
                </div>
            </a>
        @empty
            <div class="col-span-3 py-16 text-center text-neutral-500 text-xs space-y-2">
                <i class="fa-solid fa-camera text-4xl text-neutral-800"></i>
                <p class="font-bold text-white">Belum Ada Kiriman</p>
            </div>
        @endforelse
    </div>

    <div id="other-tabs-content" class="hidden py-16 text-center text-neutral-500 text-xs space-y-2">
        <i class="fa-solid fa-film text-4xl text-neutral-800"></i>
        <p class="font-bold text-white">Tidak ada konten di tab ini.</p>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function switchTab(tab) {
        document.querySelectorAll('[id^="tab-"]').forEach(btn => {
            btn.className = 'py-3 flex items-center space-x-2 border-b-2 border-transparent text-neutral-500 hover:text-white';
        });
        document.getElementById(`tab-${tab}`).className = 'py-3 flex items-center space-x-2 border-b-2 border-white text-white font-bold';

        if (tab === 'posts' || tab === 'reels') {
            document.getElementById('posts-content').classList.remove('hidden');
            document.getElementById('other-tabs-content').classList.add('hidden');
        } else {
            document.getElementById('posts-content').classList.add('hidden');
            document.getElementById('other-tabs-content').classList.remove('hidden');
        }
    }

    function toggleFollowProfile(userId, btn) {
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
                btn.textContent = data.following ? 'Mengikuti' : '+ Ikuti';
                btn.className = data.following 
                    ? 'flex-1 sm:flex-none px-8 py-2 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white font-bold text-xs transition text-center'
                    : 'flex-1 sm:flex-none px-8 py-2 rounded-xl bg-tiktok-red hover:opacity-90 text-white font-bold text-xs transition text-center';
            }
        });
    }

    function toggleSettingsMenu(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('settings-dropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    document.addEventListener('click', function(event) {
        const container = document.getElementById('settings-menu-container');
        const dropdown = document.getElementById('settings-dropdown');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (!container || !container.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const dropdown = document.getElementById('settings-dropdown');
            if (dropdown) dropdown.classList.add('hidden');
        }
    });
</script>
@endsection
