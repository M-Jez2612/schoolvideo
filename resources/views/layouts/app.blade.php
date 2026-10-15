<!DOCTYPE html>
<html lang="id" class="dark h-full bg-black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SchoolVideo - Platform Video & Media Sosial Sekolah')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#3b82f6',
                            pink: '#ec4899',
                            dark: '#0a0a0a',
                            panel: '#121212',
                            input: '#1a1a1a',
                            btn: '#0064e0'
                        }
                    },
                    animation: {
                        'disc-spin': 'discSpin 6s linear infinite'
                    },
                    keyframes: {
                        discSpin: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' }
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #000000;
            color: #ffffff;
            overflow-x: hidden;
        }
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #000000;
        }
        ::-webkit-scrollbar-thumb {
            background: #262626;
            border-radius: 9999px;
        }
    </style>
    @yield('styles')
</head>
<body class="h-full flex bg-black text-white antialiased selection:bg-blue-600 selection:text-white">

    @yield('full_layout')

    @hasSection('full_layout')
    @else
        <!-- Left Sidebar Navigation for SchoolVideo App -->
        <aside class="hidden xl:flex flex-col w-64 border-r border-neutral-900 bg-black p-4 justify-between flex-shrink-0 z-40 select-none">
            <div class="space-y-5">
                <!-- Highlighted SchoolVideo Logo (Highlight S and V) -->
                <a href="{{ route('feed') }}" class="flex items-center space-x-2.5 px-2 py-1">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-pink-500 p-0.5 shadow-lg flex items-center justify-center">
                        <div class="w-full h-full bg-black rounded-[10px] flex items-center justify-center">
                            <span class="font-black text-sm tracking-tighter">
                                <span class="text-blue-500">S</span><span class="text-pink-500">V</span>
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-xl tracking-tight font-extrabold text-white">
                            <span class="text-blue-500 text-2xl font-black">S</span>chool<span class="text-pink-500 text-2xl font-black">V</span>ideo
                        </span>
                        <span class="block text-[9px] text-neutral-400 font-bold tracking-widest uppercase">Media Sosial Sekolah</span>
                    </div>
                </a>

                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." 
                           class="w-full bg-neutral-900 border border-neutral-800 rounded-full py-2 pl-10 pr-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-blue-500 transition">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-500">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </div>
                </form>

                <!-- Menu Links -->
                <nav class="space-y-1 font-bold text-sm">
                    <a href="{{ route('feed.saran') }}" class="flex items-center space-x-4 px-3 py-3 rounded-xl transition {{ request()->routeIs('feed*') && !request()->routeIs('feed.following') ? 'text-blue-500 font-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                        <i class="fa-solid fa-house text-lg w-6"></i>
                        <span>Saran</span>
                    </a>
                    
                    <a href="{{ route('search') }}" class="flex items-center space-x-4 px-3 py-3 rounded-xl transition {{ request()->routeIs('search*') || request()->routeIs('hashtag*') ? 'text-blue-500 font-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                        <i class="fa-solid fa-compass text-lg w-6"></i>
                        <span>Jelajahi</span>
                    </a>

                    <a href="{{ route('feed.following') }}" class="flex items-center space-x-4 px-3 py-3 rounded-xl transition {{ request()->routeIs('feed.following') ? 'text-blue-500 font-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                        <i class="fa-solid fa-user-group text-lg w-6"></i>
                        <span>Mengikuti</span>
                    </a>

                    <a href="{{ route('video.upload') }}" class="flex items-center space-x-4 px-3 py-3 rounded-xl transition {{ request()->routeIs('video.upload') ? 'text-blue-500 font-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                        <i class="fa-solid fa-square-plus text-lg w-6"></i>
                        <span>Unggah</span>
                    </a>

                    @auth
                        <a href="{{ route('profile.show', Auth::id()) }}" class="flex items-center space-x-4 px-3 py-3 rounded-xl transition {{ request()->routeIs('profile.show') ? 'text-blue-500 font-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                            <img src="{{ Auth::user()->avatar_url }}" class="w-6 h-6 rounded-full object-cover border border-white">
                            <span>Profil</span>
                        </a>
                    @endauth

                    <a href="{{ route('school.profile') }}" class="flex items-center space-x-4 px-3 py-3 rounded-xl text-neutral-300 hover:bg-neutral-900 transition">
                        <i class="fa-solid fa-school text-lg w-6"></i>
                        <span>Sekolah</span>
                    </a>
                </nav>

                <!-- Login CTA Box if unauthenticated -->
                @guest
                    <div class="pt-4 border-t border-neutral-900 space-y-3">
                        <p class="text-xs text-neutral-400 leading-relaxed">Login ke SchoolVideo untuk menyukai video, memberi komentar, dan membuat postingan.</p>
                        <a href="{{ route('login') }}" class="block w-full py-2.5 rounded-xl font-bold text-center text-white bg-blue-600 hover:bg-blue-500 transition text-sm shadow-lg">
                            Log masuk
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Footer Links -->
            <div class="pt-4 border-t border-neutral-900 text-[11px] text-neutral-500 space-y-1">
                <p>Panduan • Privasi • Komunitas</p>
                <p class="text-[10px] text-neutral-600 mt-1">© 2026 <span class="font-extrabold text-white"><span class="text-blue-500">S</span>chool<span class="text-pink-500">V</span>ideo</span></p>
            </div>
        </aside>

        <!-- Main Content Body -->
        <main class="flex-1 flex flex-col h-full overflow-y-auto relative bg-black">
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="max-w-md mx-auto mt-3 px-4 z-50 fixed top-2 left-0 right-0">
                    <div class="p-3 rounded-xl bg-neutral-900 border border-emerald-500/50 text-emerald-400 text-xs font-bold flex items-center justify-between shadow-2xl backdrop-blur-md">
                        <span><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-emerald-400 ml-2"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Mobile Bottom Navigation Bar -->
        <nav class="xl:hidden fixed bottom-0 left-0 right-0 z-50 bg-black border-t border-neutral-900 py-2 px-6 select-none">
            <div class="flex justify-between items-center text-xs font-semibold">
                <a href="{{ route('feed') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('feed*') ? 'text-white font-black' : 'text-neutral-500' }}">
                    <i class="fa-solid fa-house text-lg"></i>
                    <span class="text-[10px]">Saran</span>
                </a>
                
                <a href="{{ route('search') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('search*') || request()->routeIs('hashtag*') ? 'text-white font-black' : 'text-neutral-500' }}">
                    <i class="fa-solid fa-compass text-lg"></i>
                    <span class="text-[10px]">Jelajahi</span>
                </a>

                <a href="{{ route('video.upload') }}" class="flex flex-col items-center">
                    <div class="w-10 h-7 rounded-lg bg-gradient-to-r from-blue-600 to-pink-500 p-0.5 shadow flex items-center justify-center">
                        <div class="w-full h-full bg-black rounded-[6px] flex items-center justify-center text-white">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('school.profile') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('school*') ? 'text-white font-black' : 'text-neutral-500' }}">
                    <i class="fa-solid fa-school text-lg"></i>
                    <span class="text-[10px]">Sekolah</span>
                </a>

                <a href="{{ Auth::check() ? route('profile.show', Auth::id()) : route('login') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('profile*') ? 'text-white font-black' : 'text-neutral-500' }}">
                    @auth
                        <img src="{{ Auth::user()->avatar_url }}" class="w-5 h-5 rounded-full object-cover border border-white">
                    @else
                        <i class="fa-solid fa-user text-lg"></i>
                    @endauth
                    <span class="text-[10px]">Profil</span>
                </a>
            </div>
        </nav>
    @endif

    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    @yield('scripts')
</body>
</html>
