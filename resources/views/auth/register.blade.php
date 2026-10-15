@extends('layouts.app')

@section('title', 'Daftar Akun Baru - SchoolVideo')

@section('full_layout')
<div class="w-full h-full min-h-screen flex bg-black text-white select-none">
    
    <!-- Left Section: Instagram/SchoolVideo Web Hero Showcase -->
    <div class="hidden lg:flex lg:w-7/12 xl:w-8/12 flex-col justify-between p-12 bg-black border-r border-neutral-900 relative overflow-hidden">
        
        <!-- Top Left Brand Logo -->
        <div class="flex items-center space-x-2">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-pink-500 p-0.5 shadow-lg flex items-center justify-center">
                <div class="w-full h-full bg-black rounded-[10px] flex items-center justify-center">
                    <span class="font-black text-sm tracking-tighter">
                        <span class="text-blue-500">S</span><span class="text-pink-500">V</span>
                    </span>
                </div>
            </div>
            <span class="text-2xl font-black text-white">
                <span class="text-blue-500 text-3xl font-black">S</span>chool<span class="text-pink-500 text-3xl font-black">V</span>ideo
            </span>
        </div>

        <!-- Center Showcase Content -->
        <div class="max-w-xl mx-auto text-center space-y-10 py-8 relative z-10">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight">
                Bergabunglah dengan <span class="bg-gradient-to-r from-blue-500 via-purple-400 to-pink-500 bg-clip-text text-transparent">komunitas video</span> sekolah Anda.
            </h1>

            <div class="relative w-80 h-96 mx-auto flex items-center justify-center">
                <div class="absolute w-56 h-80 rounded-3xl overflow-hidden -rotate-12 border-2 border-neutral-800 shadow-2xl bg-neutral-900 translate-x-[-40px]">
                    <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&q=80" class="w-full h-full object-cover opacity-80">
                </div>
                <div class="absolute w-60 h-84 rounded-3xl overflow-hidden border-4 border-neutral-800 shadow-2xl bg-black transform hover:scale-105 transition duration-300">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=80" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <div class="text-left text-xs text-neutral-500">
            Platform Media Sosial Video Sekolah • SMK Negeri 1 Cirebon
        </div>
    </div>

    <!-- Right Section: Instagram Style Dark Form Panel -->
    <div class="w-full lg:w-5/12 xl:w-4/12 bg-[#121212] flex flex-col justify-between p-8 sm:p-12 overflow-y-auto">
        
        <div class="my-auto space-y-5 max-w-sm mx-auto w-full">
            
            <div class="space-y-1 text-left">
                <h2 class="text-xl font-extrabold text-white">Buat akun baru</h2>
                <p class="text-xs text-neutral-400">Daftar untuk berbagi video & momen sekolah Anda.</p>
            </div>

            @if ($errors->any())
                <div class="p-3.5 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-[#1a1a1a] border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-neutral-600 transition"
                           placeholder="Nama Lengkap">
                </div>

                <div>
                    <input type="text" name="username" value="{{ old('username') }}" required
                           class="w-full bg-[#1a1a1a] border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-neutral-600 transition"
                           placeholder="Nama pengguna (username)">
                </div>

                <div>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-[#1a1a1a] border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-neutral-600 transition"
                           placeholder="Email">
                </div>

                <div>
                    <select name="role_id" required
                            class="w-full bg-[#1a1a1a] border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white focus:outline-none focus:border-neutral-600 transition">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <input type="password" name="password" required
                           class="w-full bg-[#1a1a1a] border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-neutral-600 transition"
                           placeholder="Kata sandi">

                    <input type="password" name="password_confirmation" required
                           class="w-full bg-[#1a1a1a] border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-neutral-600 transition"
                           placeholder="Ulangi kata sandi">
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-full font-bold text-white bg-[#0064e0] hover:bg-blue-600 transition text-sm shadow-lg mt-2">
                    Daftar Akun
                </button>
            </form>

            <div class="pt-4 border-t border-neutral-800 text-center">
                <a href="{{ route('login') }}" class="block w-full py-2.5 px-4 rounded-full font-bold text-center text-blue-500 border border-blue-600/60 hover:bg-blue-600/10 transition text-xs">
                    Masuk jika sudah punya akun
                </a>
            </div>

        </div>

        <div class="text-center pt-6 text-xs text-neutral-500 font-semibold flex items-center justify-center space-x-1">
            <span class="text-lg">∞</span>
            <span>SchoolVideo</span>
        </div>

    </div>

</div>
@endsection
