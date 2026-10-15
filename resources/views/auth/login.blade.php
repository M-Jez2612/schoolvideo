@extends('layouts.app')

@section('title', 'Login ke SchoolVideo')

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

        <!-- Center Showcase Content (Matching Screenshot Headline & Illustration) -->
        <div class="max-w-xl mx-auto text-center space-y-10 py-8 relative z-10">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight">
                Lihat momen sehari-hari dari <span class="bg-gradient-to-r from-pink-500 via-purple-400 to-blue-500 bg-clip-text text-transparent">teman sekolah</span> Anda.
            </h1>

            <!-- Stacked Story/Reel Mockup Cards (Matching Screenshot) -->
            <div class="relative w-80 h-96 mx-auto flex items-center justify-center">
                <!-- Card Left Background -->
                <div class="absolute w-56 h-80 rounded-3xl overflow-hidden -rotate-12 border-2 border-neutral-800 shadow-2xl bg-neutral-900 translate-x-[-40px]">
                    <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&q=80" class="w-full h-full object-cover opacity-80">
                </div>
                <!-- Card Right Background -->
                <div class="absolute w-56 h-80 rounded-3xl overflow-hidden rotate-12 border-2 border-neutral-800 shadow-2xl bg-neutral-900 translate-x-[40px]">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=80" class="w-full h-full object-cover opacity-80">
                </div>
                <!-- Main Center Story Card -->
                <div class="absolute w-60 h-84 rounded-3xl overflow-hidden border-4 border-neutral-800 shadow-2xl bg-black transform hover:scale-105 transition duration-300">
                    <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=600&q=80" class="w-full h-full object-cover">
                    <!-- Overlay Floating Heart Badges -->
                    <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between">
                        <div class="w-8 h-8 rounded-full bg-pink-500 text-white flex items-center justify-center text-sm shadow-lg">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <div class="bg-black/60 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold text-white border border-white/20">
                            ✨ Class Meeting
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer Info -->
        <div class="text-left text-xs text-neutral-500">
            Platform Media Sosial Video Sekolah • SMK Negeri 1 Cirebon
        </div>
    </div>

    <!-- Right Section: Instagram Style Dark Form Panel (Matching Screenshot Right Panel) -->
    <div class="w-full lg:w-5/12 xl:w-4/12 bg-[#121212] flex flex-col justify-between p-8 sm:p-12">
        
        <div class="my-auto space-y-6 max-w-sm mx-auto w-full">
            
            <div class="space-y-2 text-left">
                <h2 class="text-xl font-extrabold text-white">Login ke SchoolVideo</h2>
            </div>

            @if ($errors->any())
                <div class="p-3.5 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Login Form (Exact Style from Screenshot) -->
            <form action="{{ route('login') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <input type="text" name="username_or_email" value="{{ old('username_or_email') }}" required autofocus
                           class="w-full bg-[#1a1a1a] border border-neutral-800 rounded-xl py-3 px-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-neutral-600 transition"
                           placeholder="Nomor ponsel, nama pengguna, atau email">
                </div>

                <div>
                    <input type="password" name="password" required
                           class="w-full bg-[#1a1a1a] border border-neutral-800 rounded-xl py-3 px-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-neutral-600 transition"
                           placeholder="Kata sandi">
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-full font-bold text-white bg-[#0064e0] hover:bg-blue-600 transition text-sm shadow-lg mt-2">
                    Login
                </button>

                <div class="text-center pt-2">
                    <a href="javascript:void(0)" onclick="document.getElementById('demoModal').classList.remove('hidden')" class="text-xs text-neutral-400 hover:text-white font-semibold">
                        Lupa kata sandi?
                    </a>
                </div>
            </form>

            <!-- Quick Demo Accounts Option -->
            <div class="pt-4 border-t border-neutral-800 space-y-3">
                <button onclick="fillDemo('rangga_kreator')" type="button" class="w-full py-2.5 px-4 rounded-full font-semibold text-neutral-200 bg-[#1e1e1e] hover:bg-neutral-800 border border-neutral-800 transition text-xs flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-key text-blue-500"></i>
                    <span>Masuk Akun Demo (Siswa Kreator)</span>
                </button>

                <a href="{{ route('register') }}" class="block w-full py-2.5 px-4 rounded-full font-bold text-center text-blue-500 border border-blue-600/60 hover:bg-blue-600/10 transition text-xs">
                    Buat akun baru
                </a>
            </div>

        </div>

        <!-- Footer Meta Logo (Matching Screenshot Meta Footer) -->
        <div class="text-center pt-6 text-xs text-neutral-500 font-semibold flex items-center justify-center space-x-1">
            <span class="text-lg">∞</span>
            <span>SchoolVideo</span>
        </div>

    </div>

</div>

<!-- Quick Demo Account Fill Modal -->
<div id="demoModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-sm bg-[#121212] rounded-3xl border border-neutral-800 p-6 space-y-4 text-white">
        <div class="flex justify-between items-center border-b border-neutral-800 pb-2">
            <h3 class="font-bold text-sm text-white">Pilih Akun Demo</h3>
            <button onclick="document.getElementById('demoModal').classList.add('hidden')" class="text-neutral-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <p class="text-xs text-neutral-400">Password semua akun demo: <strong class="text-white">password123</strong></p>
        <div class="space-y-2">
            <button onclick="fillDemo('rangga_kreator')" class="w-full p-2.5 rounded-xl bg-neutral-900 text-left text-xs text-white hover:bg-neutral-800 block">
                <strong>Siswa Kreator:</strong> rangga_kreator
            </button>
            <button onclick="fillDemo('maulana_vendor')" class="w-full p-2.5 rounded-xl bg-neutral-900 text-left text-xs text-white hover:bg-neutral-800 block">
                <strong>Developer:</strong> maulana_vendor
            </button>
            <button onclick="fillDemo('dian_guru')" class="w-full p-2.5 rounded-xl bg-neutral-900 text-left text-xs text-white hover:bg-neutral-800 block">
                <strong>Guru:</strong> dian_guru
            </button>
            <button onclick="fillDemo('admin')" class="w-full p-2.5 rounded-xl bg-neutral-900 text-left text-xs text-white hover:bg-neutral-800 block">
                <strong>Admin:</strong> admin
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function fillDemo(username) {
        document.querySelector('input[name="username_or_email"]').value = username;
        document.querySelector('input[name="password"]').value = 'password123';
        document.getElementById('demoModal').classList.add('hidden');
    }
</script>
@endsection
