@extends('layouts.app')

@section('title', 'Edit Profil - SchoolVideo')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10 w-full flex-1">
    <div class="glass-card p-6 sm:p-8 rounded-3xl border border-slate-800 space-y-6">
        
        <div class="border-b border-slate-800 pb-4">
            <h1 class="text-xl font-extrabold text-white flex items-center">
                <i class="fa-solid fa-user-pen text-brand-400 mr-2"></i> Edit Profil Saya
            </h1>
            <p class="text-xs text-slate-400 mt-1">Perbarui nama, bio, atau foto profil Anda.</p>
        </div>

        <form action="{{ route('profile.edit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Avatar -->
            <div class="flex items-center space-x-4">
                <img src="{{ $user->avatar_url }}" class="w-16 h-16 rounded-full object-cover border-2 border-brand-500">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Ganti Foto Profil</label>
                    <input type="file" name="avatar_file" accept="image/*"
                           class="text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-white hover:file:bg-slate-700">
                </div>
            </div>

            <div>
                <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Nama Tampilan *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2.5 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div>
                <label for="full_name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $user->profile->full_name ?? $user->name) }}"
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2.5 px-4 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div>
                <label for="bio" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Bio Singkat</label>
                <textarea id="bio" name="bio" rows="3"
                          class="w-full bg-slate-900 border border-slate-700 rounded-xl py-2.5 px-4 text-xs text-white focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800">
                <a href="{{ route('profile.show', $user->id) }}" class="px-5 py-2.5 rounded-full text-xs font-semibold text-slate-400 hover:text-white">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-full font-bold text-white bg-brand-600 hover:bg-brand-500 shadow-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
