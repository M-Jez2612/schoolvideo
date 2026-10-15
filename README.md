<p align="center">
  <a href="#">
    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80" width="700" alt="SchoolVideo Banner" style="border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
  </a>
</p>

<h1 align="center">🎬 SchoolVideo - Smart School Short Video Platform</h1>

<p align="center">
  <strong>Platform Media Sosial & Video Edukasi Sekolah Terintegrasi Berbasis Algoritma Modern</strong><br>
  <em>Dikembangkan untuk ekosistem sekolah vokasi digital (SMK Negeri 1 Cirebon)</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

---

## 📖 Tentang Proyek

**SchoolVideo** adalah platform video interaktif dan jejaring sosial sekolah berbasis web modern yang menggabungkan pengalaman *Short Video Vertical Feed* (seperti TikTok & Instagram Reels) dengan sistem manajemen profil sekolah vokasi. Platform ini dirancang khusus untuk mempublikasikan karya kreatif siswa, materi pembelajaran multimedia, dokumentasi kegiatan ekstrakurikuler, serta prestasi akademik dan non-akademik.

Aplikasi ini dilengkapi dengan mesin algoritma cerdas, meliputi:
1. **TikTok-style Recommendation Engine**: Menghitung bobot tayangan, like, komentar, bagikan, kecocokan minat, dan riwayat interaksi pengguna untuk feed "Untuk Anda (For You)".
2. **Search Ranking Algorithm**: Algoritma perangkingan pencarian berdasarkan kecocokan kata kunci, relevansi kategori, popularitas konten, dan kebaruan tanggal (*recency*).
3. **Trending Content Engine**: Pendeteksi konten viral dan tagar terpopuler secara dinamis.
4. **Adaptive Video Streaming**: Mendukung HTTP 206 Partial Content Range streaming untuk pemutaran video yang mulus dan minim latensi.

---

## ✨ Fitur-Fitur Utama

### 1. 📱 Feed Video Vertikal (TikTok-Style Web Feed)
- **Tab Navigasi**: Tab **"Saran / Untuk Anda (For You)"** berbasis algoritma rekomendasi dan **"Mengikuti (Following)"** untuk kreator yang di-follow.
- **Scroll Snap Layar Penuh**: Navigasi lancar ke atas dan ke bawah (*snap scrolling*).
- **Interaksi Instan**: *Double-tap to like* dengan animasi *heart-pop*, tombol toggle like, panel komentar AJAX, dan drawer bagikan video.
- **Shortcut Keyboard**:
  - `↑` / `↓` : Pindah ke video sebelumnya / berikutnya
  - `Spasi` / `K` : Putar / Jeda video (*Play/Pause*)
  - `M` : Bisukan / Aktifkan suara (*Mute/Unmute*)
- **Konfigurasi Lompat Durasi (*Skip Duration*)**: Pilihan lompat video 5 detik, 10 detik, atau 15 detik dengan indikator animasi *ripple*.

### 2. 🎥 Pemutar & Streaming Video Lanjutan (`/v/{id}`)
- **Adaptive Streamer**: Mendukung HTTP Range Requests (Status 206) untuk video lokal maupun tautan eksternal.
- **Kontrol Kecepatan Pemutaran**: `0.5x`, `0.75x`, `1.0x (Normal)`, `1.25x`, `1.5x`, hingga `2.0x`.
- **Fitur Multimedia**: Tombol skip forward/rewind, Picture-in-Picture (PiP), Fullscreen, serta salin tautan sematan (*embed code*).
- **Rekomendasi Video Terkait**: Menampilkan video relevan dari kategori yang sama di sidebar kanan.

### 3. 💬 Interaktivitas Sosial Lengkap
- **Like & Suka**: Toggle like realtime via AJAX dengan pembaruan counter otomatis.
- **Sistem Komentar**: Menulis dan menghapus komentar secara dinamis tanpa refresh halaman.
- **Bagikan Konten**: Integrasi berbagi ke WhatsApp, Telegram, Facebook, X (Twitter), salin URL, serta kode QR.
- **Follow / Unfollow**: Hubungan sosial antar pengguna (Siswa, Guru, Alumni, Orang Tua).
- **Notifikasi Terpadu**: Notifikasi aktivitas ketika konten disukai, dikomentari, atau pengguna diikuti.

### 4. 🔍 Pencarian & Eksplorasi Tagar (`/jelajahi` & `/tag/{name}`)
- Pencarian cerdas untuk video, deskripsi, dan nama kreator.
- Filter berdasarkan kategori konten (misal: *Pembelajaran & Coding*, *Karya Creative & DKV*, *Lomba & Prestasi*, dll).
- Halaman kurasi tagar populer dengan statistik jumlah postingan.

### 5. 👥 Manajemen Peran Multi-User (RBAC)
Mendukung 5 jenis peran pengguna dalam ekosistem sekolah:
- **Administrator**: Akses dashboard metrik, moderasi video, dan kelola data master.
- **Guru / Pengajar**: Publikasi video edukasi, materi pembelajaran, dan verifikasi konten.
- **Siswa**: Upload video karya, mengikuti kompetisi, dan portofolio kejuruan.
- **Orang Tua**: Memantau aktivitas dan prestasi karya anak di sekolah.
- **Alumni**: Berbagi wawasan karir industri dan mentorship vokasi.

### 6. 🛡️ Dashboard Admin & Moderasi Konten (`/admin`)
- Ringkasan statistik platform: Total Pengguna Aktif, Total Video, Total Interaksi (Like, Komentar, Bagikan).
- Daftar konten teratas (*Top Content*) dan kreator paling aktif (*Top Creators*).
- Sistem **Persetujuan Konten (*Video Approval/Moderation*)** dengan tombol toggle persetujuan langsung.

### 7. 🏫 Profil Sekolah & Direktori Jurusan (`/sekolah`)
- Profil resmi institusi (SMK Negeri 1 Cirebon).
- Informasi Visi & Misi, Susunan Pimpinan & Struktur Organisasi.
- Data Program Keahlian / Jurusan: **PPLG**, **DKV**, **TKT**, **TO**, dan **AKL**.
- Direktori Kelas dan Profil Guru Pembimbing.

---

## 🧮 Algoritma & Rumus Perhitungan

Platform ini mengimplementasikan formula matematis sesuai standar pengujian fungsionalitas sistem:

### 1. Recommendation Score (For You Feed)
```
Skor = (Views × 0.5) + (Likes × 1.0) + (Comments × 3.0) + (Shares × 4.0) + (Kecocokan Minat × 20) + (Riwayat Interaksi × 15)
```

### 2. Search Ranking Score
```
Skor = (Kecocokan Kata Kunci × 0.40) + (Relevansi Kategori × 0.25) + (Popularitas × 0.20) + (Kebaruan Waktu × 0.15)
```

### 3. Trending Score
```
Skor = (Volume Postingan × 0.20) + (Pertumbuhan Tayangan × 0.40) + (Total Engagement × 0.25) + (Kebaruan × 0.15)
```

---

## 💻 Kebutuhan Sistem (Prerequisites)

Sebelum menginstal proyek, pastikan perangkat Anda telah memenuhi spesifikasi berikut:

- **PHP**: Versi **8.2** atau lebih tinggi
  - Ekstensi yang wajib aktif: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `curl`
- **Composer**: Versi **2.x**
- **Basis Data**: **MySQL 8.0+** / **MariaDB 10.4+** (dapat juga menggunakan SQLite)
- **Web Server**: Apache / Nginx / [Laragon](https://laragon.org/) / XAMPP / PHP Built-in Server
- **Node.js & NPM**: Versi **18+** *(opsional, untuk build asset Vite)*

---

## 🚀 Panduan Instalasi (Step-by-Step)

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Buka Direktori Proyek
Pastikan terminal / command prompt berada di root folder proyek:
```bash
cd c:\laragon\www\schoolvideo
```

### 2. Instal Dependensi PHP
Jalankan composer untuk mengunduh seluruh vendor library Laravel:
```bash
composer install
```

### 3. Konfigurasi File Lingkungan (.env)
Salin berkas template `.env.example` menjadi `.env`:
```bash
# Windows Command Prompt
copy .env.example .env

# PowerShell / Linux / macOS
cp .env.example .env
```

Buka berkas `.env` dan sesuaikan konfigurasi basis data Anda:
```env
APP_NAME=SchoolVideo
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schoolvideo
DB_USERNAME=root
DB_PASSWORD=
```

> **Catatan:** Buat database baru bernama `schoolvideo` di MySQL/phpMyAdmin sebelum menjalankan migrasi.

### 4. Generate Application Encryption Key
Buat kunci aplikasi baru untuk keamanan sesi dan enkripsi:
```bash
php artisan key:generate
```

### 5. Buat Tautan Simbolik Storage
Agar video dan thumbnail yang diunggah dapat diakses publik oleh browser:
```bash
php artisan storage:link
```

### 6. Jalankan Migrasi & Database Seeder
Perintah ini akan membuat seluruh tabel, mengisi data peran, akun pengguna, kategori, jurusan, kelas, 30+ video sampel, dan 15 skenario *test cases*:
```bash
php artisan migrate:fresh --seed
```

### 7. Jalankan Server Aplikasi
Jalankan server pengembangan Laravel:
```bash
php artisan serve
```
Aplikasi kini dapat diakses di browser melalui alamat:
👉 **[http://localhost:8000](http://localhost:8000)** (atau `http://127.0.0.1:8000`)

*(Jika menggunakan Laragon dengan auto-virtual host, aplikasi juga dapat dibuka di `http://schoolvideo.test`)*.

---

## 🔑 Akun & Kredensial Uji Coba (Demo Accounts)

Semua akun hasil seeding menggunakan **password seragam**:
> 🔒 **Password Default:** `password123`

| Peran (Role) | Nama Pengguna | Username | Email Login | Hak Akses Utama |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | Administrator Sistem | `admin` | `admin@schoolvideo.id` | Dashboard admin, moderasi video, analitik platform |
| **Guru** | Dian Kusuma, S.T. | `dian_guru` | `dian@schoolvideo.id` | Pembimbing PPLG & PKWU, verifikasi konten |
| **Guru** | Budi Santoso, M.Kom | `budi_guru` | `budi@schoolvideo.id` | Guru Basis Data & Algoritma |
| **Guru** | Hj. Siti Rahma, M.Pd | `siti_guru` | `siti@schoolvideo.id` | Wakasek Kurikulum & Pembina OSIS |
| **Siswa (Lead Dev)** | M. Maulana Sepuh | `maulana_vendor` | `mmaulana.sepuh@gmail.com` | Kreator PPLG, unggah video, interaksi feed |
| **Siswa** | Rangga Putra | `rangga_kreator` | `rangga_kreator@schoolvideo.id` | Siswa XI PPLG 1, kreator short video |
| **Siswa** | Citra Kirana | `citra_dkv` | `citra_dkv@schoolvideo.id` | Siswa XI DKV 1, kreator animasi & visual |
| **Siswa** | Hadi Sucipto | `hadi_lks` | `hadi_lks@schoolvideo.id` | Juara LKS Web Technologies |
| **Orang Tua** | Hendra Setiawan | `hendra_ortu` | `hendra@schoolvideo.id` | Wali Murid Siswa |
| **Alumni** | Rizky Febian, A.Md.Kom | `rizky_alumni` | `rizky@schoolvideo.id` | Alumni PPLG / Software Engineer |

---

## 🗺️ Peta Rute & Halaman Utama (Application Routes)

| Metode | URL / Rute | Penjelasan Halaman | Middleware |
| :--- | :--- | :--- | :--- |
| `GET` | `/` atau `/feed` | TikTok-style Feed utama (Tab "Untuk Anda" / For You) | Publik |
| `GET` | `/feed/mengikuti` | Feed khusus dari kreator yang diikuti (*Following*) | Auth |
| `GET` | `/v/{id}` | Halaman detail & pemutar video lanjutan | Publik |
| `GET` | `/v/{id}/stream`| Endpoint HTTP Range video streaming | Publik |
| `GET` | `/unggah` | Form unggah video baru & thumbnail | Auth |
| `POST` | `/unggah` | Memproses penyimpanan file video dan ekstraksi tagar | Auth |
| `GET` | `/jelajahi` | Eksplorasi video, filter kategori & tagar | Publik |
| `GET` | `/tag/{name}` | Halaman filter feed berdasarkan hashtag | Publik |
| `GET` | `/u/{id}` | Halaman profil publik kreator & grid video | Publik |
| `GET` | `/profile/edit`| Form update biodata & foto profil pengguna | Auth |
| `GET` | `/admin` | Dashboard Admin, statistik & moderasi video | Auth (Admin/Guru) |
| `POST` | `/admin/v/{id}/approve` | Toggle persetujuan status publikasi video | Auth (Admin/Guru) |
| `GET` | `/sekolah` | Profil resmi sekolah, jurusan, & pimpinan | Publik |
| `GET` | `/login` / `/register` | Halaman autentikasi akun | Guest |
| `POST` | `/logout` | Keluar dari sesi pengguna | Auth |

---

## 🧪 Pengujian Fungsionalitas (Test Cases)

Platform ini telah melalui 15 skenario pengujian komprehensif yang tersimpan pada tabel `test_cases`:

| ID | Fitur | Skenario Uji | Hasil yang Diharapkan | Status |
| :--- | :--- | :--- | :--- | :---: |
| **TC-001** | Authentication | Pendaftaran Akun Baru (Register) | Akun baru berhasil dibuat, password di-hash (Bcrypt), session aktif | ✅ **PASSED** |
| **TC-002** | Authentication | Login User (Admin/Guru/Siswa) | Login berhasil dan diarahkan sesuai hak akses peran | ✅ **PASSED** |
| **TC-003** | Authentication | Logout User | Session dihapus dan diarahkan kembali ke landing page | ✅ **PASSED** |
| **TC-004** | Profile | Melihat & Mengedit Profil User | Foto profil, bio, counter followers/following diperbarui | ✅ **PASSED** |
| **TC-005** | Video Post | Unggah Video Baru (Create Post) | Video terunggah, thumbnail tergenerasi, hashtag terikat | ✅ **PASSED** |
| **TC-006** | Video Post | Mengubah Data Video (Edit Post) | Judul, deskripsi, dan kategori berhasil diperbarui | ✅ **PASSED** |
| **TC-007** | Video Post | Menghapus Video (Delete Post) | Video dan relasi interaksi terhapus secara *cascade* | ✅ **PASSED** |
| **TC-008** | Social Interaction | Toggle Like Video | Counter like bertambah/berkurang secara dinamis (AJAX) | ✅ **PASSED** |
| **TC-009** | Social Interaction | Menambah Komentar Video | Komentar muncul di daftar dan counter komentar bertambah | ✅ **PASSED** |
| **TC-010** | Social Interaction | Follow & Unfollow Kreator | Status relasi berubah & jumlah pengikut terbarui | ✅ **PASSED** |
| **TC-011** | Search Engine | Pencarian Kata Kunci & Ranking | Hasil diurutkan berdasarkan formula *Search Score Ranking* | ✅ **PASSED** |
| **TC-012** | Hashtag Engine | Filter Video per Hashtag (#PPLG) | Menampilkan daftar video yang terkait dengan tagar | ✅ **PASSED** |
| **TC-013** | Recommendation | Feed For You Recommendation | Video diurutkan berdasar bobot algoritma TikTok-style | ✅ **PASSED** |
| **TC-014** | Trending System | Deteksi Konten & Topik Populer | Konten dengan lonjakan interaksi masuk peringkat trending | ✅ **PASSED** |
| **TC-015** | UI/UX & Security | Responsivitas & Access Control | Tampilan adaptif mobile/desktop, proteksi CSRF & XSS aktif | ✅ **PASSED** |

---

## 📂 Struktur Direktori Proyek

```
schoolvideo/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AdminController.php         # Kontroler dashboard admin & moderasi
│   │       ├── AuthController.php          # Kontroler login, register, logout
│   │       ├── FeedController.php          # Kontroler feed TikTok (For You & Following)
│   │       ├── HomeController.php          # Kontroler landing page
│   │       ├── InteractionController.php   # Like, komentar, share, follow
│   │       ├── ProfileController.php       # Profil pengguna & edit bio
│   │       ├── SchoolController.php        # Profil sekolah & jurusan
│   │       ├── SearchController.php        # Pencarian & halaman tagar
│   │       └── VideoController.php         # Unggah, stream HTTP 206, detail video
│   └── Models/                             # 19 Model Eloquent (User, Video, Like, dll)
├── database/
│   ├── migrations/                         # Skema tabel database
│   └── seeders/
│       └── DatabaseSeeder.php              # Seeder data awal, video dummy & test cases
├── public/                                 # Entry point aplikasi & aset publik
├── resources/
│   └── views/                              # Template Blade
│       ├── admin/                          # Tampilan dashboard admin
│       ├── auth/                           # Tampilan login & register
│       ├── feed/                           # Tampilan feed TikTok vertikal
│       ├── layouts/                        # Layout utama (app.blade.php)
│       ├── profile/                        # Halaman profil kreator
│       ├── school/                         # Tampilan profil sekolah & jurusan
│       ├── search/                         # Halaman eksplorasi & hashtag
│       └── video/                          # Tampilan player & form upload
├── routes/
│   └── web.php                             # Definisi seluruh rute aplikasi
└── storage/
    └── app/public/videos/                  # Tempat penyimpanan file video fisik
```

---

## 💡 Troubleshooting & Masalah Umum

1. **Video tidak bisa diputar atau muncul layar hitam:**
   - Pastikan perintah `php artisan storage:link` telah dijalankan.
   - Periksa izin folder `storage/app/public` agar dapat dibaca oleh web server.
   - Endpoint streaming menggunakan `/v/{id}/stream` yang mengalirkan file secara bertahap via buffer stream.

2. **Kesalahan "Access denied for user 'root'@'localhost'":**
   - Periksa konfigurasi `DB_USERNAME` dan `DB_PASSWORD` pada file `.env`.
   - Pastikan service MySQL pada Laragon atau XAMPP sudah dalam kondisi *Running*.

3. **Penyimpanan file video besar (HTTP 413 / Request Entity Too Large):**
   - Sesuaikan konfigurasi `upload_max_filesize` dan `post_max_size` pada `php.ini` (disarankan minimal `64M` atau `128M`).

---

## 📄 Lisensi

Proyek ini berada di bawah lisensi terbuka [MIT License](LICENSE). Bebas digunakan dan dikembangkan untuk keperluan edukasi dan pembelajaran vokasi.

<p align="center">
  Dibuat dengan ❤️ untuk kemajuan pendidikan vokasi digital Indonesia 🇮🇩
</p>

