@extends('layouts.app')

@section('title', 'Studio Unggah Video - SchoolVideo')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 w-full flex-1">
    
    <!-- Top Header -->
    <div class="flex items-center justify-between pb-6 border-b border-neutral-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight flex items-center">
                <i class="fa-solid fa-cloud-arrow-up text-tiktok-red mr-3"></i> Detail Unggahan Video
            </h1>
            <p class="text-xs text-neutral-400 mt-1">Publikasikan karya kreatif dan materi pembelajaran Anda ke komunitas SchoolVideo.</p>
        </div>
        <a href="{{ route('feed') }}" class="px-4 py-2 rounded-xl bg-neutral-900 hover:bg-neutral-800 text-xs font-bold text-neutral-300 transition flex items-center space-x-1.5 border border-neutral-800">
            <i class="fa-solid fa-xmark"></i>
            <span>Kembali ke Feed</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="mt-4 p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center"><i class="fa-solid fa-circle-exclamation mr-2"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form id="uploadVideoForm" action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Form Detail (TikTok Studio Upload Style) -->
            <div class="lg:col-span-7 space-y-6">

                <!-- 1. Video Source Picker (File or URL) -->
                <div class="bg-[#18181b] border border-neutral-800 rounded-2xl p-5 space-y-4 shadow-xl">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-extrabold uppercase tracking-wider text-neutral-200 flex items-center">
                            <i class="fa-solid fa-file-video text-tiktok-red mr-2"></i> Berkas Video *
                        </label>
                        <span class="text-[11px] text-neutral-400 font-medium">MP4, WebM (Maks. 50MB)</span>
                    </div>

                    <div class="border-2 border-dashed border-neutral-700 hover:border-tiktok-red rounded-2xl p-6 text-center bg-black/40 transition cursor-pointer group"
                         onclick="document.getElementById('video_file').click()">
                        <div class="w-14 h-14 rounded-full bg-neutral-800/80 group-hover:bg-tiktok-red/20 flex items-center justify-center mx-auto text-tiktok-red text-2xl transition shadow">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        </div>
                        <p class="text-xs font-bold text-white mt-3">Pilih video untuk diunggah</p>
                        <p class="text-[11px] text-neutral-400 mt-1">Atau seret dan lepas berkas video ke sini</p>
                        <p id="video-file-name" class="text-xs text-emerald-400 font-bold mt-2 hidden"></p>
                        <input type="file" id="video_file" name="video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime" class="hidden" onchange="handleVideoFilePick(this)">
                    </div>

                    <div class="relative flex items-center justify-center">
                        <div class="w-full border-t border-neutral-800"></div>
                        <span class="absolute bg-[#18181b] px-3 text-[10px] font-bold uppercase tracking-wider text-neutral-500">Atau Gunakan Tautan URL</span>
                    </div>

                    <div>
                        <input type="url" id="video_url_input" name="video_url_input" value="{{ old('video_url_input') }}"
                               class="w-full bg-black/60 border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-tiktok-red transition"
                               placeholder="https://assets.mixkit.co/videos/preview/...mp4" oninput="handleVideoUrlInput(this)">
                    </div>
                </div>

                <!-- 2. Judul Video (Ditambahkan sebelum Deskripsi sesuai request) -->
                <div class="bg-[#18181b] border border-neutral-800 rounded-2xl p-5 space-y-3 shadow-xl">
                    <div class="flex items-center justify-between">
                        <label for="title" class="text-xs font-extrabold text-white uppercase tracking-wider flex items-center">
                            Judul Video <span class="text-tiktok-red ml-1">*</span>
                        </label>
                        <span class="text-[10px] text-neutral-400 font-medium">Wajib diisi</span>
                    </div>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full bg-black/60 border border-neutral-800 rounded-xl py-2.5 px-4 text-xs font-semibold text-white placeholder-neutral-500 focus:outline-none focus:border-tiktok-red transition"
                           placeholder="Tambahkan judul video yang menarik...">

                    <!-- Kategori -->
                    <div class="pt-2">
                        <label for="category_id" class="block text-[11px] font-bold text-neutral-400 mb-1">Kategori Video *</label>
                        <select id="category_id" name="category_id" required
                                class="w-full bg-black/60 border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white focus:outline-none focus:border-tiktok-red transition">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- 3. Deskripsi Video (Card dengan # Tagar, @ Sebut & Counter) -->
                <div class="bg-[#18181b] border border-neutral-800 rounded-2xl p-5 space-y-3 shadow-xl">
                    <div class="flex items-center justify-between">
                        <label for="description" class="text-xs font-extrabold text-white uppercase tracking-wider">
                            Deskripsi
                        </label>
                    </div>

                    <div class="bg-black/60 border border-neutral-800 rounded-xl p-3 focus-within:border-tiktok-red transition">
                        <textarea id="description" name="description" rows="4" maxlength="4000"
                                  class="w-full bg-transparent border-0 text-xs text-white placeholder-neutral-500 focus:outline-none resize-none leading-relaxed"
                                  placeholder="Ceritakan tentang video Anda...">{{ old('description') }}</textarea>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-neutral-800/80 text-[11px]">
                            <!-- Quick action tag buttons -->
                            <div class="flex items-center space-x-2">
                                <button type="button" onclick="insertTag('#')" class="px-2.5 py-1 rounded-lg bg-neutral-800 hover:bg-neutral-700 text-neutral-300 font-bold transition flex items-center space-x-1">
                                    <span>#</span> <span>Tagar</span>
                                </button>
                                <button type="button" onclick="insertTag('@')" class="px-2.5 py-1 rounded-lg bg-neutral-800 hover:bg-neutral-700 text-neutral-300 font-bold transition flex items-center space-x-1">
                                    <span>@</span> <span>Sebut</span>
                                </button>
                            </div>
                            <span class="text-neutral-500 font-mono text-[10px]"><span id="descCharCount">0</span>/4000</span>
                        </div>
                    </div>

                    <!-- Input Hashtags Tersembunyi/Otomatis -->
                    <div>
                        <label for="hashtags_input" class="block text-[11px] font-bold text-neutral-400 mb-1">Hashtag Terkait</label>
                        <input type="text" id="hashtags_input" name="hashtags_input" value="{{ old('hashtags_input', 'SchoolVideo, PPLG, PrestasiSiswa') }}"
                               class="w-full bg-black/60 border border-neutral-800 rounded-xl py-2 px-3 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-tiktok-red transition"
                               placeholder="Contoh: SchoolVideo, Coding, BelajarWeb">
                    </div>
                </div>

                <!-- 4. Sampul (Thumbnail Section Sesuai Gambar Desain) -->
                <div class="bg-[#18181b] border border-neutral-800 rounded-2xl p-5 space-y-3 shadow-xl">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-white uppercase tracking-wider flex items-center">
                            Sampul <i class="fa-regular fa-circle-question text-neutral-500 ml-1.5 cursor-pointer" title="Pilih gambar untuk menjadi thumbnail video"></i>
                        </span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Thumbnail Card Preview -->
                        <div class="relative w-28 aspect-[3/4] bg-neutral-900 rounded-xl overflow-hidden border border-neutral-700 shadow-lg group">
                            <img id="thumbnailPreviewImg" src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=80"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <button type="button" onclick="document.getElementById('thumbnail_file').click()"
                                    class="absolute bottom-0 left-0 right-0 py-1.5 bg-black/80 hover:bg-black text-[11px] font-bold text-white text-center transition flex items-center justify-center space-x-1">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                                <span>Edit sampul</span>
                            </button>
                        </div>

                        <!-- Info & Pick Button -->
                        <div class="space-y-2 flex-1">
                            <p class="text-xs font-semibold text-neutral-200">Unggah Gambar Sampul Khusus</p>
                            <p class="text-[11px] text-neutral-400 leading-relaxed">Pilih gambar rasio vertikal atau horizontal yang mewakili konten video Anda.</p>
                            <button type="button" onclick="document.getElementById('thumbnail_file').click()"
                                    class="px-4 py-2 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-xs font-bold text-white transition border border-neutral-700 flex items-center space-x-2">
                                <i class="fa-solid fa-image"></i>
                                <span>Pilih Gambar dari Perangkat</span>
                            </button>
                            <input type="file" id="thumbnail_file" name="thumbnail_file" accept="image/*" class="hidden" onchange="handleThumbnailFilePick(this)">
                        </div>
                    </div>
                </div>

                <!-- 5. Pengaturan (Posting Time, Audience, High Quality Toggle) -->
                <div class="bg-[#18181b] border border-neutral-800 rounded-2xl p-5 space-y-4 shadow-xl">
                    <h3 class="text-xs font-extrabold text-white uppercase tracking-wider">Pengaturan</h3>

                    <!-- Waktu Posting -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-neutral-300">Waktu posting</label>
                        <div class="flex items-center space-x-6 text-xs text-neutral-300">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="post_time" value="now" checked class="accent-tiktok-red w-4 h-4">
                                <span class="font-bold text-white">Sekarang</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer text-neutral-400 hover:text-white">
                                <input type="radio" name="post_time" value="schedule" class="accent-tiktok-red w-4 h-4">
                                <span>Jadwalkan <i class="fa-regular fa-circle-question text-[10px] ml-0.5"></i></span>
                            </label>
                        </div>
                    </div>

                    <!-- Siapa yang dapat melihat postingan ini -->
                    <div class="space-y-2 pt-2 border-t border-neutral-800">
                        <label class="block text-xs font-semibold text-neutral-300">Siapa yang dapat melihat postingan ini</label>
                        <select class="w-full bg-black/60 border border-neutral-800 rounded-xl py-2.5 px-4 text-xs text-white focus:outline-none focus:border-tiktok-red transition">
                            <option value="public">Publik (Semua Pengguna)</option>
                            <option value="followers">Pengikut</option>
                            <option value="private">Hanya Saya</option>
                        </select>
                    </div>

                    <!-- Unggahan Berkualitas Tinggi (Toggle) -->
                    <div class="flex items-center justify-between pt-2 border-t border-neutral-800">
                        <div>
                            <p class="text-xs font-bold text-white flex items-center">
                                Unggahan berkualitas tinggi <i class="fa-regular fa-circle-question text-neutral-500 ml-1.5 cursor-pointer"></i>
                            </p>
                            <p class="text-[11px] text-neutral-400 mt-0.5">HD secara default saat kamu memosting dari Web Studio</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-tiktok-cyan"></div>
                        </label>
                    </div>
                </div>

                <!-- 6. Pemeriksaan (Pemeriksaan Hak Cipta & Konten Ringan) -->
                <div class="bg-[#18181b] border border-neutral-800 rounded-2xl p-5 space-y-4 shadow-xl">
                    <h3 class="text-xs font-extrabold text-white uppercase tracking-wider">Pemeriksaan</h3>

                    <!-- Pemeriksaan Hak Cipta -->
                    <div class="flex items-start justify-between">
                        <div class="space-y-0.5 max-w-md">
                            <p class="text-xs font-bold text-white flex items-center">
                                Pemeriksaan hak cipta musik <i class="fa-regular fa-circle-question text-neutral-500 ml-1.5"></i>
                            </p>
                            <p class="text-[11px] text-neutral-400 leading-snug">
                                Kami akan memeriksa apakah video Anda memiliki musik yang tidak sah yang dapat menyebabkannya dibisukan. Anda juga dapat mengatur <span class="text-blue-400 underline cursor-pointer">pemeriksaan otomatis</span>
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 ml-4">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-tiktok-cyan"></div>
                        </label>
                    </div>

                    <!-- Pemeriksaan Konten Ringan -->
                    <div class="flex items-start justify-between pt-3 border-t border-neutral-800">
                        <div class="space-y-0.5 max-w-md">
                            <p class="text-xs font-bold text-white flex items-center">
                                Pemeriksaan konten ringan <i class="fa-regular fa-circle-question text-neutral-500 ml-1.5"></i>
                            </p>
                            <p class="text-[11px] text-neutral-400 leading-snug">
                                Kami akan memeriksa konten Anda untuk kelayakan feed Saran. Anda juga dapat mengatur <span class="text-blue-400 underline cursor-pointer">pemeriksaan otomatis</span>
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 ml-4">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-tiktok-cyan"></div>
                        </label>
                    </div>
                </div>

                <!-- 7. Action Buttons Bar (Posting, Simpan Draf, Buang) -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <button type="submit" id="btnSubmitPost"
                            class="px-8 py-3 rounded-xl bg-tiktok-red hover:opacity-90 font-extrabold text-white text-xs transition shadow-lg shadow-tiktok-red/20 flex items-center space-x-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Posting</span>
                    </button>

                    <button type="button" onclick="saveAsDraft()"
                            class="px-6 py-3 rounded-xl bg-neutral-800 hover:bg-neutral-700 font-bold text-white text-xs transition border border-neutral-700">
                        Simpan draf
                    </button>

                    <a href="{{ route('feed') }}"
                       class="px-6 py-3 rounded-xl bg-neutral-900 hover:bg-neutral-800 font-bold text-neutral-400 hover:text-white text-xs transition border border-neutral-800">
                        Buang
                    </a>
                </div>

            </div>

            <!-- Right Column: Smartphone Mockup Video Preview (Contoh Video) -->
            <div class="lg:col-span-5 flex flex-col items-center sticky top-8">
                
                <!-- Mockup Tab Selector -->
                <div class="w-full max-w-[320px] flex items-center justify-between pb-3 text-xs">
                    <div class="flex items-center space-x-1 bg-neutral-900 p-1 rounded-xl border border-neutral-800">
                        <button type="button" class="px-3 py-1 rounded-lg bg-neutral-800 text-white font-bold text-[11px] shadow">Feed</button>
                        <button type="button" class="px-3 py-1 rounded-lg text-neutral-400 hover:text-white text-[11px]">Profil</button>
                        <button type="button" class="px-3 py-1 rounded-lg text-neutral-400 hover:text-white text-[11px]">Web</button>
                    </div>
                    <button type="button" class="text-neutral-400 hover:text-white p-1" title="Pratinjau Layar Penuh">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </button>
                </div>

                <!-- Phone Frame Mockup -->
                <div class="relative w-[300px] h-[580px] bg-black rounded-[40px] border-[6px] border-neutral-800 shadow-2xl overflow-hidden flex flex-col justify-between select-none">
                    
                    <!-- Top Status Bar & Notch -->
                    <div class="absolute top-2 left-0 right-0 px-6 flex items-center justify-between z-30 text-[10px] text-white font-semibold">
                        <span>8:00</span>
                        <div class="w-20 h-4 bg-neutral-900 rounded-full mx-auto"></div>
                        <div class="flex items-center space-x-1">
                            <i class="fa-solid fa-wifi text-[9px]"></i>
                            <i class="fa-solid fa-battery-full text-[9px]"></i>
                        </div>
                    </div>

                    <!-- Phone Header Tabs: Following | For You -->
                    <div class="absolute top-8 left-0 right-0 px-4 flex items-center justify-center space-x-4 z-30 text-xs font-extrabold text-neutral-400 drop-shadow">
                        <span class="hover:text-white cursor-pointer">Following</span>
                        <span class="text-white border-b-2 border-white pb-0.5">For You</span>
                        <i class="fa-solid fa-magnifying-glass text-xs absolute right-4 text-white"></i>
                    </div>

                    <!-- Video Preview Player Inside Mockup -->
                    <div class="relative w-full h-full bg-neutral-950 flex items-center justify-center overflow-hidden">
                        <video id="mockupVideoPlayer" class="w-full h-full object-contain cursor-pointer" autoplay loop muted playsinline>
                            <source src="https://assets.mixkit.co/videos/preview/mixkit-software-developer-working-on-code-41551-large.mp4" type="video/mp4">
                        </video>
                    </div>

                    <!-- Right Vertical Action Icons Inside Mockup -->
                    <div class="absolute right-3 bottom-20 z-30 flex flex-col items-center space-y-3 text-white">
                        <!-- Avatar -->
                        <div class="relative">
                            <img src="{{ Auth::user()->avatar_url ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=schoolvideo' }}"
                                 class="w-9 h-9 rounded-full object-cover border-2 border-white">
                            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-3.5 h-3.5 rounded-full bg-tiktok-red text-white flex items-center justify-center text-[8px]">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                        </div>

                        <!-- Heart -->
                        <div class="text-center">
                            <i class="fa-solid fa-heart text-xl drop-shadow text-white"></i>
                            <span class="block text-[9px] font-bold mt-0.5">24.5K</span>
                        </div>

                        <!-- Comment -->
                        <div class="text-center">
                            <i class="fa-solid fa-comment-dots text-xl drop-shadow text-white"></i>
                            <span class="block text-[9px] font-bold mt-0.5">188</span>
                        </div>

                        <!-- Bookmark -->
                        <div class="text-center">
                            <i class="fa-solid fa-bookmark text-xl drop-shadow text-white"></i>
                            <span class="block text-[9px] font-bold mt-0.5">5.2K</span>
                        </div>

                        <!-- Share -->
                        <div class="text-center">
                            <i class="fa-solid fa-share text-xl drop-shadow text-white"></i>
                            <span class="block text-[9px] font-bold mt-0.5">940</span>
                        </div>

                        <!-- Rotating Music Disc -->
                        <div class="w-8 h-8 rounded-full bg-black p-0.5 border border-neutral-700 animate-disc-spin">
                            <img src="{{ Auth::user()->avatar_url ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=schoolvideo' }}" class="w-full h-full rounded-full object-cover">
                        </div>
                    </div>

                    <!-- Bottom Caption Inside Mockup -->
                    <div class="absolute bottom-10 left-3 right-16 z-30 text-white space-y-1 text-left drop-shadow">
                        <p class="font-bold text-xs">@ {{ Auth::user()->username ?? 'creator_video' }}</p>
                        <p id="mockupCaptionText" class="text-[11px] leading-snug line-clamp-2 text-neutral-200">
                            Tutorial pembuatan aplikasi SchoolVideo dengan Laravel 11.
                        </p>
                        <p class="text-[10px] text-neutral-300 flex items-center space-x-1 pt-0.5">
                            <i class="fa-solid fa-music text-[9px]"></i>
                            <span class="truncate">Suara asli - {{ Auth::user()->name ?? 'SchoolVideo' }}</span>
                        </p>
                    </div>

                    <!-- Bottom Navigation Bar Inside Mockup -->
                    <div class="absolute bottom-0 left-0 right-0 h-10 bg-black/90 backdrop-blur border-t border-neutral-800 flex items-center justify-around text-neutral-400 text-[9px] z-30">
                        <span class="text-white font-bold flex flex-col items-center"><i class="fa-solid fa-house"></i> Home</span>
                        <span class="flex flex-col items-center"><i class="fa-solid fa-user-group"></i> Teman</span>
                        <div class="w-7 h-5 rounded-md bg-white text-black flex items-center justify-center font-bold text-xs"><i class="fa-solid fa-plus"></i></div>
                        <span class="flex flex-col items-center"><i class="fa-solid fa-message"></i> Kotak Masuk</span>
                        <span class="flex flex-col items-center"><i class="fa-solid fa-user"></i> Profil</span>
                    </div>

                </div>

                <!-- Mockup Quick Edit Tools Below Phone -->
                <div class="flex items-center space-x-2 pt-4">
                    <button type="button" class="px-3.5 py-1.5 rounded-xl bg-neutral-900 border border-neutral-800 text-[11px] font-bold text-neutral-300 hover:text-white transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-scissors text-tiktok-red"></i>
                        <span>Edit</span>
                    </button>
                    <button type="button" class="px-3.5 py-1.5 rounded-xl bg-neutral-900 border border-neutral-800 text-[11px] font-bold text-neutral-300 hover:text-white transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-music text-tiktok-cyan"></i>
                        <span>Suara</span>
                    </button>
                    <button type="button" class="px-3.5 py-1.5 rounded-xl bg-neutral-900 border border-neutral-800 text-[11px] font-bold text-neutral-300 hover:text-white transition flex items-center space-x-1.5">
                        <span class="font-serif font-black text-xs">Aa</span>
                        <span>Teks</span>
                    </button>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // 1. Sync Description with Phone Mockup Caption and Character Counter
    const descArea = document.getElementById('description');
    const mockupCaption = document.getElementById('mockupCaptionText');
    const charCounter = document.getElementById('descCharCount');

    if (descArea) {
        descArea.addEventListener('input', function() {
            if (mockupCaption) {
                mockupCaption.textContent = this.value.trim() || 'Deskripsi video Anda akan muncul di sini...';
            }
            if (charCounter) {
                charCounter.textContent = this.value.length;
            }
        });
    }

    function insertTag(symbol) {
        if (!descArea) return;
        const start = descArea.selectionStart;
        const end = descArea.selectionEnd;
        const text = descArea.value;
        descArea.value = text.substring(0, start) + symbol + text.substring(end);
        descArea.focus();
        descArea.selectionStart = descArea.selectionEnd = start + symbol.length;
        descArea.dispatchEvent(new Event('input'));
    }

    // 2. Video File Pick & Preview in Mockup Player
    function handleVideoFilePick(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileNameDisplay = document.getElementById('video-file-name');
            if (fileNameDisplay) {
                fileNameDisplay.textContent = '✓ ' + file.name + ' (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB)';
                fileNameDisplay.classList.remove('hidden');
            }

            // Auto-fill title if empty
            const titleInput = document.getElementById('title');
            if (titleInput && !titleInput.value) {
                const cleanName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
                titleInput.value = cleanName.charAt(0).toUpperCase() + cleanName.slice(1);
            }

            // Load to Mockup Video
            const objUrl = URL.createObjectURL(file);
            const mockupVideo = document.getElementById('mockupVideoPlayer');
            if (mockupVideo) {
                mockupVideo.src = objUrl;
                mockupVideo.play().catch(() => {});
            }
        }
    }

    function handleVideoUrlInput(input) {
        const val = input.value.trim();
        if (val && val.startsWith('http')) {
            const mockupVideo = document.getElementById('mockupVideoPlayer');
            if (mockupVideo) {
                mockupVideo.src = val;
                mockupVideo.play().catch(() => {});
            }
        }
    }

    // 3. Thumbnail Pick & Preview
    function handleThumbnailFilePick(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('thumbnailPreviewImg');
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function saveAsDraft() {
        alert('Draf video Anda telah disimpan secara lokal!');
    }
</script>
@endsection
