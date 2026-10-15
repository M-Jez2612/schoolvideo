@extends('layouts.app')

@section('title', 'Direktori Warga Sekolah - SchoolVideo')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 w-full flex-1 space-y-8">
    
    <div class="glass-card p-6 rounded-3xl space-y-2">
        <h1 class="text-2xl font-extrabold text-white flex items-center">
            <i class="fa-solid fa-address-book text-brand-400 mr-2"></i> Direktori Guru & Siswa Sekolah
        </h1>
        <p class="text-xs text-slate-400">Daftar tenaga pendidik dan peserta didik SMK Negeri 1 Cirebon.</p>
    </div>

    <!-- Teachers Section -->
    <div class="space-y-4">
        <h3 class="text-base font-bold text-white uppercase tracking-wider flex items-center">
            <i class="fa-solid fa-chalkboard-user text-accent-pink mr-2"></i> Data Guru Pengajar
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($teachers as $teacher)
                <a href="{{ route('profile.show', $teacher->user->id) }}" class="glass-card p-4 rounded-2xl flex items-center space-x-3 hover:border-brand-500/50 transition">
                    <img src="{{ $teacher->user->avatar_url }}" class="w-12 h-12 rounded-full object-cover border-2 border-accent-pink">
                    <div>
                        <h4 class="font-extrabold text-white text-sm">{{ $teacher->user->name }}</h4>
                        <p class="text-xs text-brand-400 font-semibold">{{ $teacher->subject ?? 'Guru' }}</p>
                        <p class="text-[10px] text-slate-500">NIP: {{ $teacher->nip ?? '-' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Classes & Students Directory -->
    <div class="space-y-4">
        <h3 class="text-base font-bold text-white uppercase tracking-wider flex items-center">
            <i class="fa-solid fa-users text-emerald-400 mr-2"></i> Direktori Siswa per Rombongan Belajar
        </h3>

        @foreach($classes as $c)
            <div class="glass-card p-6 rounded-3xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div>
                        <h4 class="font-extrabold text-white text-lg">{{ $c->name }}</h4>
                        <p class="text-xs text-slate-400">{{ $c->major->name ?? 'Jurusan' }}</p>
                    </div>
                    <span class="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
                        {{ count($c->students) }} Siswa Registered
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($c->students as $student)
                        <a href="{{ route('profile.show', $student->user->id) }}" class="p-3 bg-slate-900/80 rounded-xl flex items-center space-x-2.5 border border-slate-800/80 hover:border-brand-500/50 transition">
                            <img src="{{ $student->user->avatar_url }}" class="w-8 h-8 rounded-full object-cover">
                            <div class="overflow-hidden">
                                <p class="text-xs font-bold text-white truncate">{{ $student->user->name }}</p>
                                <p class="text-[10px] text-slate-400 truncate">@ {{ $student->user->username }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
