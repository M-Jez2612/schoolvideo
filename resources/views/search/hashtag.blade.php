@extends('layouts.app')

@section('title', '#' . $hashtag->name . ' - SchoolVideo')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 w-full flex-1 space-y-8">
    
    <!-- Hashtag Banner -->
    <div class="glass-card p-8 rounded-3xl flex flex-col sm:flex-row items-center justify-between gap-6 bg-gradient-to-r from-brand-900/40 to-accent-purple/20">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-600 to-accent-pink flex items-center justify-center text-white text-3xl shadow-xl">
                #
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-white">#{{ $hashtag->name }}</h1>
                <p class="text-xs text-slate-400 mt-1">Digunakan dalam {{ $hashtag->posts_count }} postingan video sekolah</p>
            </div>
        </div>

        <a href="{{ route('feed') }}" class="px-6 py-2.5 rounded-full text-xs font-bold text-white bg-slate-800 hover:bg-slate-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Feed
        </a>
    </div>

    <!-- Video Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
            <div class="glass-card rounded-2xl overflow-hidden hover:border-brand-500/50 transition duration-300 group flex flex-col">
                <div class="relative aspect-video bg-slate-950 overflow-hidden">
                    <img src="{{ $video->thumbnail_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <a href="{{ route('video.show', $video->id) }}" class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition">
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center shadow-lg transform group-hover:scale-110 transition">
                            <i class="fa-solid fa-play ml-0.5"></i>
                        </div>
                    </a>
                </div>

                <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                    <div>
                        <a href="{{ route('video.show', $video->id) }}" class="text-base font-bold text-white line-clamp-2 hover:text-brand-400 transition">
                            {{ $video->title }}
                        </a>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-800 text-xs text-slate-400">
                        <div class="flex items-center space-x-2">
                            <img src="{{ $video->user->avatar_url }}" class="w-6 h-6 rounded-full object-cover">
                            <span class="font-medium text-slate-300 truncate max-w-[120px]">{{ $video->user->name }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-slate-400">
                            <span><i class="fa-solid fa-eye mr-1 text-slate-500"></i>{{ $video->views_count }}</span>
                            <span><i class="fa-solid fa-heart mr-1 text-red-500"></i>{{ $video->likes_count }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full glass-card p-12 text-center text-slate-400">
                Belum ada video dengan tagar #{{ $hashtag->name }}.
            </div>
        @endforelse
    </div>

</div>
@endsection
