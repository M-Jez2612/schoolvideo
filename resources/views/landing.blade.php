@extends('layouts.app')

@section('title', 'SchoolVideo - Platform Video Sekolah & Short Video Terintegrasi')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden pt-12 pb-20 bg-gradient-to-b from-navy-950 via-slate-900 to-navy-950">
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-gradient-to-tr from-brand-600/30 to-accent-pink/30 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span>
                    <span>Tender Proyek PKWU • Paket 25 - SchoolVideo</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                    Platform Video Sekolah <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-brand-400 via-indigo-400 to-accent-pink bg-clip-text text-transparent">
                        Short Video & Algorithm
                    </span>
                </h1>

                <p class="text-slate-300 text-base sm:text-lg max-w-2xl font-normal leading-relaxed mx-auto lg:mx-0">
                    Integrasi sistem manajemen sekolah dengan media sosial berbasis video pendek modern. Dilengkapi <strong>Search Engine Ranking</strong>, <strong>TikTok-style Recommendation Engine</strong>, dan <strong>Trending Analytics Engine</strong>.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('feed') }}" class="px-8 py-3.5 rounded-full font-bold text-white bg-gradient-to-r from-brand-600 via-indigo-600 to-accent-pink hover:opacity-90 shadow-xl shadow-brand-500/25 transition duration-300 transform hover:-translate-y-0.5 flex items-center space-x-2">
                        <i class="fa-solid fa-circle-play text-lg"></i>
                        <span>Jelajahi Feed Video</span>
                    </a>

                    <a href="{{ route('tender.docs') }}" class="px-6 py-3.5 rounded-full font-semibold text-amber-400 bg-amber-500/10 border border-amber-500/30 hover:bg-amber-500/20 transition duration-300 flex items-center space-x-2">
                        <i class="fa-solid fa-file-invoice text-sm"></i>
                        <span>Lihat Proposal & RAB</span>
                    </a>
                </div>

                <!-- Stats Badge Row -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-8 border-t border-slate-800">
                    <div class="glass-card p-3 rounded-xl text-center">
                        <p class="text-2xl font-extrabold text-white">{{ $stats['total_users'] }}</p>
                        <p class="text-xs text-slate-400 font-medium">Pengguna</p>
                    </div>
                    <div class="glass-card p-3 rounded-xl text-center">
                        <p class="text-2xl font-extrabold text-brand-400">{{ $stats['total_videos'] }}</p>
                        <p class="text-xs text-slate-400 font-medium">Video Diunggah</p>
                    </div>
                    <div class="glass-card p-3 rounded-xl text-center">
                        <p class="text-2xl font-extrabold text-accent-pink">{{ number_format($stats['total_likes']) }}</p>
                        <p class="text-xs text-slate-400 font-medium">Total Likes</p>
                    </div>
                    <div class="glass-card p-3 rounded-xl text-center">
                        <p class="text-2xl font-extrabold text-emerald-400">{{ number_format($stats['total_views']) }}</p>
                        <p class="text-xs text-slate-400 font-medium">Total Penayangan</p>
                    </div>
                </div>

            </div>

            <!-- Right Hero Phone Frame Showcase -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-full max-w-xs sm:max-w-sm">
                    <!-- Glow Behind Phone -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-brand-500 to-accent-pink rounded-[40px] blur-2xl opacity-40 animate-pulse"></div>

                    <!-- Simulated Phone Frame -->
                    <div class="relative bg-slate-950 p-3 rounded-[40px] border-4 border-slate-800 shadow-2xl">
                        <!-- Phone Notch -->
                        <div class="w-32 h-5 bg-slate-900 rounded-b-xl mx-auto mb-2 flex items-center justify-center space-x-2">
                            <div class="w-2 h-2 rounded-full bg-slate-800"></div>
                            <div class="w-10 h-1.5 rounded-full bg-slate-800"></div>
                        </div>

                        <!-- Phone Screen Player Mockup -->
                        <div class="relative aspect-[9/16] rounded-[30px] overflow-hidden bg-slate-900 shadow-inner group">
                            <video class="w-full h-full object-cover" autoplay loop muted playsinline>
                                <source src="https://assets.mixkit.co/videos/preview/mixkit-software-developer-working-on-code-41551-large.mp4" type="video/mp4">
                            </video>

                            <!-- Overlay Gradient & Controls -->
                            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/80 p-4 flex flex-col justify-between">
                                <!-- Top Bar -->
                                <div class="flex justify-between items-center text-white text-xs">
                                    <span class="bg-black/40 px-2 py-0.5 rounded-full font-bold">✨ For You</span>
                                    <span class="bg-brand-600/80 px-2 py-0.5 rounded-full font-semibold">Live Algorithm</span>
                                </div>

                                <!-- Right Side Actions -->
                                <div class="self-end space-y-3 text-white text-center">
                                    <div class="w-10 h-10 rounded-full bg-slate-800/80 p-0.5 border border-white/20 shadow">
                                        <img src="https://api.dicebear.com/7.x/bottts/svg?seed=maulana_vendor" class="w-full h-full rounded-full">
                                    </div>
                                    <div>
                                        <i class="fa-solid fa-heart text-red-500 text-lg"></i>
                                        <p class="text-[10px] font-bold">320</p>
                                    </div>
                                    <div>
                                        <i class="fa-solid fa-comment text-white text-lg"></i>
                                        <p class="text-[10px] font-bold">45</p>
                                    </div>
                                    <div>
                                        <i class="fa-solid fa-share text-white text-lg"></i>
                                        <p class="text-[10px] font-bold">88</p>
                                    </div>
                                </div>

                                <!-- Bottom Info -->
                                <div class="text-white text-left space-y-1">
                                    <p class="text-xs font-bold">@maulana_vendor • Vendor IT</p>
                                    <p class="text-[11px] line-clamp-2 text-slate-200">Tutorial Dasar Coding PHP & Recommendation Engine #PPLG #SchoolVideo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Featured Videos Grid (Bab 5.1 Konten Unggulan) -->
<section class="py-16 bg-slate-900/60 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Konten Unggulan Sekolah</h2>
                <p class="text-sm text-slate-400 mt-1">Video terbaik pilihan algoritma rekomendasi dan engagement tertinggi.</p>
            </div>
            <a href="{{ route('feed') }}" class="mt-4 sm:mt-0 text-sm font-semibold text-brand-400 hover:text-brand-300 flex items-center">
                Lihat Semua Feed <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredVideos as $video)
                <div class="glass-card rounded-2xl overflow-hidden hover:border-brand-500/50 transition-all duration-300 group flex flex-col">
                    <div class="relative aspect-video bg-slate-950 overflow-hidden">
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <a href="{{ route('video.show', $video->id) }}" class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center shadow-lg transform group-hover:scale-110 transition">
                                <i class="fa-solid fa-play ml-0.5"></i>
                            </a>
                        </div>
                        <span class="absolute bottom-2 right-2 bg-black/70 px-2 py-0.5 rounded text-[11px] font-mono text-white">
                            0:{{ $video->duration }}
                        </span>
                        <span class="absolute top-2 left-2 bg-brand-600/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                            {{ $video->category->name ?? 'Umum' }}
                        </span>
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
            @endforeach
        </div>
    </div>
</section>

<!-- Core Features Overview (Bab 5 Wajib) -->
<section class="py-16 bg-navy-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <span class="text-xs font-bold text-brand-400 tracking-widest uppercase">Fitur Core Wajib & Spesifikasi Paket 25</span>
            <h2 class="text-3xl font-extrabold text-white">Arsitektur Fitur & Ekosistem Digital</h2>
            <p class="text-slate-400 text-sm">Dikembangkan sesuai Kerangka Acuan Kerja (KAK) Tugas Proyek PKWU XI PPLG.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="glass-card p-6 rounded-2xl space-y-3 hover:border-brand-500/40 transition">
                <div class="w-12 h-12 rounded-xl bg-brand-500/10 text-brand-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Authentication & Multi-Role</h3>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Mendukung role <strong>Admin</strong>, <strong>Guru</strong>, <strong>Siswa</strong>, <strong>Orang Tua</strong>, dan <strong>Alumni</strong> dengan kontrol hak akses (RBAC) dan password hashing aman.
                </p>
            </div>

            <div class="glass-card p-6 rounded-2xl space-y-3 hover:border-accent-pink/40 transition">
                <div class="w-12 h-12 rounded-xl bg-accent-pink/10 text-accent-pink flex items-center justify-center text-xl">
                    <i class="fa-solid fa-video"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Short Video Feed (TikTok-style)</h3>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Tampilan reel video vertikal interaktif untuk upload karya, tutorial, event sekolah, like, comment, share, dan follow kreator.
                </p>
            </div>

            <div class="glass-card p-6 rounded-2xl space-y-3 hover:border-emerald-500/40 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-brain"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Algorithm Recommendation</h3>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Mesin rekomendasi cerdas yang menghitung <strong>Search Score</strong>, <strong>Recommendation Score</strong> (View, Like, Comment, Share, Interest), dan <strong>Trending Score</strong>.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Information School & Tender CTA Section -->
<section class="py-12 bg-gradient-to-r from-brand-900/40 via-indigo-900/30 to-navy-950 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card p-8 rounded-3xl flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="space-y-3 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 text-amber-400 font-bold text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-building-columns"></i>
                    <span>{{ $school->school_name ?? 'SMK Negeri 1 Cirebon' }}</span>
                </div>
                <h3 class="text-2xl font-bold text-white">Dokumen Tender & Rencana Anggaran Biaya (RAB)</h3>
                <p class="text-slate-300 text-sm max-w-2xl">
                    Tersedia Proposal Teknis lengkap, Profil Vendor, Analisis Masalah, Business Model Canvas, dan 15 Test Cases UAT Interactive Suite.
                </p>
            </div>
            <a href="{{ route('tender.docs') }}" class="px-8 py-4 rounded-full font-bold text-navy-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl transition whitespace-nowrap">
                Buka Dokumen Tender & Business <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</section>
@endsection
