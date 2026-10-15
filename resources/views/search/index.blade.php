@extends('layouts.app')

@section('title', 'Jelajahi - SchoolVideo')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 w-full flex-1 space-y-8 select-none">
    
    <!-- Explore Search Header -->
    <div class="bg-neutral-900/80 p-6 rounded-3xl border border-neutral-800 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-white flex items-center">
                    <i class="fa-solid fa-compass text-blue-500 mr-2.5"></i> Jelajahi Konten Sekolah
                </h1>
                <p class="text-xs text-neutral-400 mt-1">Temukan video pendek, tutorial, event, dan karya siswa SMK Negeri 1 Cirebon.</p>
            </div>
        </div>

        <form action="{{ route('search') }}" method="GET" class="flex flex-col sm:flex-row gap-3 pt-2">
            <div class="relative flex-1">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari kata kunci, koding, futsal, PPLG, hashtag..." 
                       class="w-full bg-black border border-neutral-800 rounded-2xl py-3 pl-11 pr-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-blue-500 transition">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-500">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <select name="category" class="bg-black border border-neutral-800 rounded-2xl px-4 py-3 text-xs text-white focus:outline-none focus:border-blue-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-8 py-3 rounded-2xl font-bold text-white bg-blue-600 hover:bg-blue-500 transition text-xs shadow-lg">
                Cari Konten
            </button>
        </form>

        <!-- Top 10 Trending Hashtags Box -->
        <div class="pt-3 border-t border-neutral-800/80 space-y-2">
            <div class="flex items-center justify-between text-xs">
                <span class="font-extrabold text-white flex items-center">
                    <i class="fa-solid fa-fire text-pink-500 mr-1.5"></i> Top 10 Tagar Terpopuler
                </span>
                <span class="text-[10px] text-neutral-500 font-semibold">Dibatasi Maksimal 10 Tagar Utama</span>
            </div>
            
            <div class="flex flex-wrap items-center gap-2">
                @foreach($trendingHashtags as $tag)
                    <a href="{{ route('hashtag.show', $tag->name) }}" class="px-3.5 py-1.5 rounded-full bg-black hover:bg-neutral-800 border border-neutral-800 text-xs font-bold text-neutral-300 hover:text-white transition flex items-center space-x-1">
                        <span class="text-blue-500">#{{ $tag->name }}</span>
                        <span class="text-[10px] bg-neutral-800 text-neutral-400 px-1.5 py-0.5 rounded-full ml-1">{{ $tag->posts_count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Matching Users Row (If query matching) -->
    @if(count($users) > 0)
        <div class="space-y-3">
            <h3 class="text-xs font-extrabold text-neutral-400 uppercase tracking-wider">Pengguna Ditemukan ({{ count($users) }})</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($users as $user)
                    <a href="{{ route('profile.show', $user->id) }}" class="p-3 bg-neutral-900 rounded-2xl flex items-center space-x-3 border border-neutral-800 hover:border-blue-500/50 transition">
                        <img src="{{ $user->avatar_url }}" class="w-10 h-10 rounded-full object-cover border border-neutral-700">
                        <div>
                            <h4 class="font-extrabold text-white text-xs">{{ $user->name }}</h4>
                            <p class="text-[10px] text-neutral-400">@ {{ $user->username }} • {{ ucfirst($user->role->name ?? 'User') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Video Grid (Instagram / TikTok Explore Grid) -->
    <div class="space-y-4">
        <h3 class="text-xs font-extrabold text-neutral-400 uppercase tracking-wider">
            Galeri Video ({{ count($videos) }})
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($videos as $video)
                <div class="bg-neutral-900 rounded-2xl overflow-hidden border border-neutral-800/80 hover:border-neutral-700 transition duration-300 group flex flex-col">
                    <div class="relative aspect-video bg-black overflow-hidden">
                        <img src="{{ $video->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        
                        <span class="absolute top-2 left-2 bg-black/80 backdrop-blur text-white text-[10px] font-bold px-2 py-0.5 rounded-full border border-white/10">
                            {{ $video->category->name ?? 'Umum' }}
                        </span>

                        <a href="{{ route('video.show', $video->id) }}" class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition">
                            <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg transform group-hover:scale-110 transition">
                                <i class="fa-solid fa-play ml-0.5"></i>
                            </div>
                        </a>
                    </div>

                    <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <a href="{{ route('video.show', $video->id) }}" class="text-sm font-bold text-white line-clamp-2 hover:text-blue-400 transition">
                                {{ $video->title }}
                            </a>
                            <p class="text-xs text-neutral-400 line-clamp-2 mt-1">{{ $video->description }}</p>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-neutral-800 text-xs text-neutral-400">
                            <div class="flex items-center space-x-2">
                                <img src="{{ $video->user->avatar_url }}" class="w-6 h-6 rounded-full object-cover">
                                <span class="font-medium text-neutral-300 truncate max-w-[120px]">{{ $video->user->name }}</span>
                            </div>
                            <div class="flex items-center space-x-3 text-neutral-400 text-xs">
                                <span><i class="fa-solid fa-eye mr-1 text-neutral-500"></i>{{ $video->views_count }}</span>
                                <span><i class="fa-solid fa-heart mr-1 text-pink-500"></i>{{ $video->likes_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-neutral-900 p-12 text-center text-neutral-400 rounded-3xl space-y-2">
                    <i class="fa-solid fa-magnifying-glass text-3xl text-neutral-600"></i>
                    <p class="text-sm font-bold text-white">Tidak ada video ditemukan.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
