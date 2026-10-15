@extends('layouts.app')

@section('title', 'Admin Intelligence Dashboard - SchoolVideo')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 w-full flex-1 space-y-8">
    
    <!-- Header -->
    <div class="glass-card p-6 sm:p-8 rounded-3xl space-y-2 border border-slate-800 bg-gradient-to-r from-navy-950 via-slate-900 to-emerald-950">
        <div class="inline-flex items-center space-x-2 text-xs font-bold text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20 uppercase tracking-wider">
            <i class="fa-solid fa-chart-line"></i>
            <span>Bab 36.7 Admin Intelligence Dashboard</span>
        </div>
        <h1 class="text-3xl font-extrabold text-white">Panel Analitik & Moderation System</h1>
        <p class="text-xs text-slate-300">Ringkasan aktivitas pengguna, tren konten, dan moderasi publikasi sekolah.</p>
    </div>

    <!-- 6 Primary Metrics Cards (Bab 36.7) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="glass-card p-4 rounded-2xl text-center space-y-1">
            <span class="text-xs text-slate-400 font-semibold block">TOTAL USERS</span>
            <p class="text-2xl font-black text-white">{{ $stats['total_users'] }}</p>
        </div>
        <div class="glass-card p-4 rounded-2xl text-center space-y-1">
            <span class="text-xs text-slate-400 font-semibold block">ACTIVE USERS</span>
            <p class="text-2xl font-black text-brand-400">{{ $stats['active_users'] }}</p>
        </div>
        <div class="glass-card p-4 rounded-2xl text-center space-y-1">
            <span class="text-xs text-slate-400 font-semibold block">TOTAL POSTS</span>
            <p class="text-2xl font-black text-indigo-400">{{ $stats['total_posts'] }}</p>
        </div>
        <div class="glass-card p-4 rounded-2xl text-center space-y-1">
            <span class="text-xs text-slate-400 font-semibold block">TOTAL COMMENTS</span>
            <p class="text-2xl font-black text-amber-400">{{ $stats['total_comments'] }}</p>
        </div>
        <div class="glass-card p-4 rounded-2xl text-center space-y-1">
            <span class="text-xs text-slate-400 font-semibold block">TOTAL LIKES</span>
            <p class="text-2xl font-black text-accent-pink">{{ number_format($stats['total_likes']) }}</p>
        </div>
        <div class="glass-card p-4 rounded-2xl text-center space-y-1">
            <span class="text-xs text-slate-400 font-semibold block">TOTAL SHARES</span>
            <p class="text-2xl font-black text-emerald-400">{{ number_format($stats['total_shares']) }}</p>
        </div>
    </div>

    <!-- Analytics & Top Lists Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Top Content (5 Most Viewed) -->
        <div class="lg:col-span-8 glass-card p-6 rounded-3xl space-y-4">
            <h3 class="text-base font-bold text-white flex items-center">
                <i class="fa-solid fa-trophy text-amber-400 mr-2"></i> Top Content (Konten Terpopuler)
            </h3>

            <div class="space-y-3">
                @foreach($topContent as $index => $v)
                    <div class="p-3 bg-slate-900/80 rounded-2xl border border-slate-800 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="w-7 h-7 rounded-lg bg-slate-800 font-extrabold text-xs text-brand-400 flex items-center justify-center">
                                #{{ $index + 1 }}
                            </span>
                            <div>
                                <a href="{{ route('video.show', $v->id) }}" class="font-bold text-white text-xs hover:underline line-clamp-1">
                                    {{ $v->title }}
                                </a>
                                <p class="text-[10px] text-slate-400">Oleh {{ $v->user->name }} • {{ $v->category->name ?? 'Umum' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 text-xs font-mono text-slate-300">
                            <span><i class="fa-solid fa-eye text-slate-500 mr-1"></i>{{ $v->views_count }}</span>
                            <span><i class="fa-solid fa-heart text-red-500 mr-1"></i>{{ $v->likes_count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Trending Topics & Top Users -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Trending Topics -->
            <div class="glass-card p-6 rounded-3xl space-y-3">
                <h3 class="text-sm font-bold text-white flex items-center">
                    <i class="fa-solid fa-fire text-red-500 mr-2"></i> Trending Topics (#Tagar)
                </h3>
                <div class="space-y-2">
                    @foreach($trendingTopics as $tag)
                        <div class="flex justify-between items-center text-xs p-2 rounded-xl bg-slate-900/60 border border-slate-800">
                            <a href="{{ route('hashtag.show', $tag->name) }}" class="font-bold text-brand-400 hover:underline">
                                #{{ $tag->name }}
                            </a>
                            <span class="text-slate-400 text-[10px] font-mono">{{ $tag->posts_count }} posts</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Users -->
            <div class="glass-card p-6 rounded-3xl space-y-3">
                <h3 class="text-sm font-bold text-white flex items-center">
                    <i class="fa-solid fa-user-star text-amber-400 mr-2"></i> Top Users (Kreator Aktif)
                </h3>
                <div class="space-y-2">
                    @foreach($topUsers as $user)
                        <div class="flex justify-between items-center text-xs p-2 rounded-xl bg-slate-900/60 border border-slate-800">
                            <div class="flex items-center space-x-2">
                                <img src="{{ $user->avatar_url }}" class="w-6 h-6 rounded-full object-cover">
                                <span class="font-bold text-white truncate max-w-[100px]">{{ $user->name }}</span>
                            </div>
                            <span class="text-slate-400 text-[10px] font-mono">{{ $user->videos_count }} video</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
