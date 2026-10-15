@extends('layouts.app')

@section('title', 'Profil & Informasi Sekolah - SchoolVideo')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 w-full flex-1 space-y-8">
    
    <!-- Hero School Card -->
    <div class="glass-card p-8 rounded-3xl relative overflow-hidden border border-slate-800 bg-gradient-to-r from-navy-950 via-slate-900 to-indigo-950">
        <div class="space-y-4 max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-400 text-xs font-bold border border-brand-500/20">
                <i class="fa-solid fa-school"></i>
                <span>NPSN: {{ $school->npsn ?? '20220202' }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white">{{ $school->school_name ?? 'SMK Negeri 1 Cirebon' }}</h1>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed"><i class="fa-solid fa-location-dot text-red-400 mr-1.5"></i>{{ $school->address }}</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 pt-6 border-t border-slate-800">
            <div class="p-3 bg-slate-900/80 rounded-xl text-center">
                <p class="text-xl font-black text-white">{{ $totalStudents }}</p>
                <p class="text-[11px] text-slate-400 font-semibold">Total Siswa</p>
            </div>
            <div class="p-3 bg-slate-900/80 rounded-xl text-center">
                <p class="text-xl font-black text-brand-400">{{ count($teachers) }}</p>
                <p class="text-[11px] text-slate-400 font-semibold">Guru Pengajar</p>
            </div>
            <div class="p-3 bg-slate-900/80 rounded-xl text-center">
                <p class="text-xl font-black text-accent-pink">{{ count($majors) }}</p>
                <p class="text-[11px] text-slate-400 font-semibold">Jurusan Keahlian</p>
            </div>
            <div class="p-3 bg-slate-900/80 rounded-xl text-center">
                <p class="text-xl font-black text-emerald-400">{{ $totalClasses }}</p>
                <p class="text-[11px] text-slate-400 font-semibold">Rombongan Belajar</p>
            </div>
        </div>
    </div>

    <!-- Vision & Mission Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="glass-card p-6 rounded-3xl space-y-3">
            <h3 class="text-lg font-bold text-white flex items-center">
                <i class="fa-solid fa-eye text-brand-400 mr-2"></i> Visi Sekolah
            </h3>
            <p class="text-xs text-slate-300 leading-relaxed">{{ $school->vision }}</p>
        </div>

        <div class="glass-card p-6 rounded-3xl space-y-3">
            <h3 class="text-lg font-bold text-white flex items-center">
                <i class="fa-solid fa-bullseye text-accent-pink mr-2"></i> Misi Sekolah
            </h3>
            <div class="text-xs text-slate-300 leading-relaxed whitespace-pre-line">{{ $school->mission }}</div>
        </div>
    </div>

    <!-- Majors & Competencies -->
    <div class="space-y-4">
        <h3 class="text-lg font-bold text-white flex items-center">
            <i class="fa-solid fa-layer-group text-emerald-400 mr-2"></i> Program Keahlian / Jurusan
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($majors as $major)
                <div class="glass-card p-6 rounded-2xl space-y-3 hover:border-brand-500/50 transition">
                    <div class="flex items-center justify-between">
                        <span class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-400 font-extrabold text-sm flex items-center justify-center">
                            {{ $major->code }}
                        </span>
                        <span class="text-xs text-slate-400 font-semibold">{{ $major->students_count }} Siswa</span>
                    </div>
                    <h4 class="font-extrabold text-white text-base">{{ $major->name }}</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">{{ $major->description }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Facilities -->
    <div class="glass-card p-6 rounded-3xl space-y-4">
        <h3 class="text-lg font-bold text-white flex items-center">
            <i class="fa-solid fa-microchip text-indigo-400 mr-2"></i> Fasilitas Ekosistem Digital
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
            @foreach($school->facilities ?? [] as $facility)
                <div class="p-3 bg-slate-900/80 rounded-xl text-center border border-slate-800 text-xs font-semibold text-slate-300">
                    <i class="fa-solid fa-circle-check text-emerald-400 block text-base mb-1"></i>
                    {{ $facility }}
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
