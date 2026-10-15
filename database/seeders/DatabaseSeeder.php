<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentUser;
use App\Models\Alumni;
use App\Models\Category;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Share;
use App\Models\Hashtag;
use App\Models\VideoHashtag;
use App\Models\Follower;
use App\Models\Notification;
use App\Models\UserInteraction;
use App\Models\SchoolProfile;
use App\Models\TestCase;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator']);
        $guruRole  = Role::create(['name' => 'guru', 'display_name' => 'Guru / Pengajar']);
        $siswaRole = Role::create(['name' => 'siswa', 'display_name' => 'Siswa']);
        $parentRole = Role::create(['name' => 'orang_tua', 'display_name' => 'Orang Tua']);
        $alumniRole = Role::create(['name' => 'alumni', 'display_name' => 'Alumni']);

        // 2. School Profile
        SchoolProfile::create([
            'school_name' => 'SMK Negeri 1 Cirebon - Smart School Platform',
            'npsn' => '20220202',
            'vision' => 'Menjadi pusat keunggulan pendidikan vokasi berbasis teknologi digital dan kewirausahaan modern.',
            'mission' => "1. Menyelenggarakan pembelajaran berbasis proyek berstandar industri.\n2. Mengintegrasikan teknologi informasi dalam ekosistem sekolah.\n3. Mengembangkan jiwa kreatif dan kewirausahaan (PKWU) peserta didik.",
            'structure' => 'Kepala Sekolah: Drs. H. Ahmad Wijaya, M.Pd | Wakasek Kurikulum: Dra. Hj. Siti Rahma | Wakasek Kesiswaan: Agus Hermawan, S.Kom | Ka. Program PPLG: Bu Dian, S.T.',
            'facilities' => ['Lab Komputer PPLG', 'Studio Creative DKV', 'Bengkel Otomotif Modern', 'Perpustakaan Digital', 'Smart Classroom', 'Kantin Digital'],
            'address' => 'Jl. Perjuangan No. 10, Sunyaragi, Kesambi, Kota Cirebon, Jawa Barat',
            'phone' => '(0231) 482910',
            'email' => 'info@smkn1cirebon.sch.id'
        ]);

        // 3. Majors (Jurusan)
        $pplg = Major::create(['name' => 'Pengembangan Perangkat Lunak dan Gim', 'code' => 'PPLG', 'description' => 'Jurusan rekayasa perangkat lunak, aplikasi web, mobile, dan gim.', 'icon' => 'code']);
        $dkv  = Major::create(['name' => 'Desain Komunikasi Visual', 'code' => 'DKV', 'description' => 'Jurusan animasi, fotografi, videografi, dan desain grafis.', 'icon' => 'palette']);
        $tkt  = Major::create(['name' => 'Teknik Jaringan Komputer dan Telekomunikasi', 'code' => 'TKT', 'description' => 'Jurusan jaringan, siber, dan infrastruktur cloud.', 'icon' => 'network']);
        $to   = Major::create(['name' => 'Teknik Otomotif', 'code' => 'TO', 'description' => 'Jurusan kelistrikan dan mekanik kendaraan modern.', 'icon' => 'wrench']);
        $akl  = Major::create(['name' => 'Akuntansi dan Keuangan Lembaga', 'code' => 'AKL', 'description' => 'Jurusan manajemen keuangan dan perbankan digital.', 'icon' => 'calculator']);

        // 4. Classes (Kelas)
        $c_pplg1 = SchoolClass::create(['major_id' => $pplg->id, 'name' => 'XI PPLG 1', 'grade_level' => 'XI']);
        $c_pplg2 = SchoolClass::create(['major_id' => $pplg->id, 'name' => 'XI PPLG 2', 'grade_level' => 'XI']);
        $c_dkv1  = SchoolClass::create(['major_id' => $dkv->id,  'name' => 'XI DKV 1',  'grade_level' => 'XI']);
        $c_tkt1  = SchoolClass::create(['major_id' => $tkt->id,  'name' => 'XI TKT 1',  'grade_level' => 'XI']);

        // 5. Categories
        $cat_coding = Category::create(['name' => 'Pembelajaran & Coding', 'slug' => 'pembelajaran-coding', 'icon' => 'code']);
        $cat_ekskul = Category::create(['name' => 'Ekstrakurikuler & Seni', 'slug' => 'ekstrakurikuler-seni', 'icon' => 'music']);
        $cat_lomba  = Category::create(['name' => 'Lomba & Prestasi', 'slug' => 'lomba-prestasi', 'icon' => 'trophy']);
        $cat_event  = Category::create(['name' => 'Class Meeting & Event', 'slug' => 'class-meeting-event', 'icon' => 'calendar']);
        $cat_dkv    = Category::create(['name' => 'Karya Creative & DKV', 'slug' => 'karya-creative-dkv', 'icon' => 'video']);

        // 6. Hashtags
        $ht_schoolvideo = Hashtag::create(['name' => 'SchoolVideo', 'posts_count' => 12]);
        $ht_pplg        = Hashtag::create(['name' => 'PPLG', 'posts_count' => 15]);
        $ht_prestasi    = Hashtag::create(['name' => 'PrestasiSiswa', 'posts_count' => 8]);
        $ht_classmeet   = Hashtag::create(['name' => 'ClassMeeting', 'posts_count' => 10]);
        $ht_lks         = Hashtag::create(['name' => 'LKS2026', 'posts_count' => 6]);
        $ht_coding      = Hashtag::create(['name' => 'CodingPHP', 'posts_count' => 9]);

        // 7. Users (20 Users Minimal)
        $password = Hash::make('password123');

        // Admin User
        $u_admin = User::create(['role_id' => $adminRole->id, 'name' => 'Administrator Sekolah', 'username' => 'admin', 'email' => 'admin@schoolvideo.id', 'password' => $password]);
        Profile::create(['user_id' => $u_admin->id, 'full_name' => 'System Administrator', 'bio' => 'Pengelola Utama Platform Digital SchoolVideo SMK Negeri 1 Cirebon.']);

        // Teacher Users
        $u_dian = User::create(['role_id' => $guruRole->id, 'name' => 'Bu Dian, S.T.', 'username' => 'dian_guru', 'email' => 'dian@schoolvideo.id', 'password' => $password]);
        Profile::create(['user_id' => $u_dian->id, 'full_name' => 'Dian Kusuma, S.T.', 'bio' => 'Guru Produktif PPLG & Pembimbing Proyek PKWU SchoolVideo.']);
        Teacher::create(['user_id' => $u_dian->id, 'nip' => '198504122010012003', 'subject' => 'Pemrograman Web & PKWU']);

        $u_budi = User::create(['role_id' => $guruRole->id, 'name' => 'Pak Budi Santoso', 'username' => 'budi_guru', 'email' => 'budi@schoolvideo.id', 'password' => $password]);
        Profile::create(['user_id' => $u_budi->id, 'full_name' => 'Budi Santoso, M.Kom', 'bio' => 'Guru Basis Data & Algoritma Pemrograman.']);
        Teacher::create(['user_id' => $u_budi->id, 'nip' => '198208152008041002', 'subject' => 'Basis Data & Algoritma']);

        $u_siti = User::create(['role_id' => $guruRole->id, 'name' => 'Bu Siti Rahma', 'username' => 'siti_guru', 'email' => 'siti@schoolvideo.id', 'password' => $password]);
        Profile::create(['user_id' => $u_siti->id, 'full_name' => 'Hj. Siti Rahma, M.Pd', 'bio' => 'Wakasek Kurikulum & Pembina OSIS.']);
        Teacher::create(['user_id' => $u_siti->id, 'nip' => '197903202005012001', 'subject' => 'Bahasa Indonesia & Multimedia']);

        // Vendor / Lead Developer Student (Maulana - Paket 25)
        $u_maulana = User::create(['role_id' => $siswaRole->id, 'name' => 'Muhammad Maulana Sepuh', 'username' => 'maulana_vendor', 'email' => 'mmaulana.sepuh@gmail.com', 'password' => $password]);
        Profile::create(['user_id' => $u_maulana->id, 'full_name' => 'Muhammad Maulana Sepuh', 'bio' => 'Vendor IT / Lead Developer SchoolVideo Paket 25 XI RPL. "Build it, Test it, Explain it, Sell it."', 'gender' => 'L']);
        Student::create(['user_id' => $u_maulana->id, 'class_id' => $c_pplg1->id, 'major_id' => $pplg->id, 'nisn' => '0061234501']);

        // Student Users (13 more students)
        $studentsData = [
            ['name' => 'Rangga Putra', 'username' => 'rangga_kreator', 'class' => $c_pplg1, 'major' => $pplg, 'bio' => 'Siswa XI PPLG 1 | Content Creator Code & Short Video.'],
            ['name' => 'Sari Indah', 'username' => 'sari_penonton', 'class' => $c_pplg1, 'major' => $pplg, 'bio' => 'Siswa XI PPLG 1 | Hobi koding & editing video.'],
            ['name' => 'Andi Wijaya', 'username' => 'andi_coder', 'class' => $c_pplg1, 'major' => $pplg, 'bio' => 'PHP & Laravel Developer enthusiast.'],
            ['name' => 'Budi Pratama', 'username' => 'budi_gamer', 'class' => $c_pplg2, 'major' => $pplg, 'bio' => 'Game Developer XI PPLG 2.'],
            ['name' => 'Citra Kirana', 'username' => 'citra_dkv', 'class' => $c_dkv1, 'major' => $dkv, 'bio' => 'Animator & Motion Designer XI DKV 1.'],
            ['name' => 'Dewi Lestari', 'username' => 'dewi_art', 'class' => $c_dkv1, 'major' => $dkv, 'bio' => 'Illustrator & Short Video Visual Artist.'],
            ['name' => 'Eko Prasetyo', 'username' => 'eko_network', 'class' => $c_tkt1, 'major' => $tkt, 'bio' => 'Cloud & Network Administrator XI TKT 1.'],
            ['name' => 'Fajar Nugraha', 'username' => 'fajar_robotics', 'class' => $c_pplg2, 'major' => $pplg, 'bio' => 'IoT & Robotics Programmer.'],
            ['name' => 'Gita Gutawa', 'username' => 'gita_music', 'class' => $c_dkv1, 'major' => $dkv, 'bio' => 'Vokalis Band Ekstrakurikuler Musik Sekolah.'],
            ['name' => 'Hadi Sucipto', 'username' => 'hadi_lks', 'class' => $c_pplg1, 'major' => $pplg, 'bio' => 'Juara 1 LKS Web Technologies Cirebon 2026.'],
            ['name' => 'Intan Permata', 'username' => 'intan_osis', 'class' => $c_pplg1, 'major' => $pplg, 'bio' => 'Ketua OSIS SMK Negeri 1 Cirebon.'],
            ['name' => 'Joko Susilo', 'username' => 'joko_otomotif', 'class' => $c_tkt1, 'major' => $to, 'bio' => 'Kreator Tutorial Kendaraan Listrik.'],
            ['name' => 'Kiki Amalia', 'username' => 'kiki_dance', 'class' => $c_dkv1, 'major' => $dkv, 'bio' => 'Tim Tari Modern & Cheerleader Sekolah.'],
        ];

        $studentModels = [$u_maulana];
        foreach ($studentsData as $idx => $s) {
            $u = User::create([
                'role_id' => $siswaRole->id,
                'name' => $s['name'],
                'username' => $s['username'],
                'email' => $s['username'] . '@schoolvideo.id',
                'password' => $password,
            ]);
            Profile::create(['user_id' => $u->id, 'full_name' => $s['name'], 'bio' => $s['bio']]);
            Student::create(['user_id' => $u->id, 'class_id' => $s['class']->id, 'major_id' => $s['major']->id, 'nisn' => '006123450' . ($idx + 2)]);
            $studentModels[] = $u;
        }

        // Parent User
        $u_parent = User::create(['role_id' => $parentRole->id, 'name' => 'Bapak Hendra (Orang Tua Rangga)', 'username' => 'hendra_ortu', 'email' => 'hendra@schoolvideo.id', 'password' => $password]);
        Profile::create(['user_id' => $u_parent->id, 'full_name' => 'Hendra Setiawan', 'bio' => 'Wali Murid Rangga Putra (XI PPLG 1)']);

        // Alumni User
        $u_alumni = User::create(['role_id' => $alumniRole->id, 'name' => 'Rizky Febian (Alumni PPLG 2024)', 'username' => 'rizky_alumni', 'email' => 'rizky@schoolvideo.id', 'password' => $password]);
        Profile::create(['user_id' => $u_alumni->id, 'full_name' => 'Rizky Febian, A.Md.Kom', 'bio' => 'Alumni PPLG 2024 | Software Engineer di Tech Unicorn Jakarta.']);

        // 8. Videos (30 Videos Minimal with direct sample web MP4s / dynamic HTML5 video loops)
        $sampleVideos = [
            [
                'title' => 'Tutorial Dasar Coding PHP 8 & Laravel 11 untuk Pemula',
                'description' => 'Video tutorial membuat RESTful API dan Blade View menggunakan PHP & Laravel di XI PPLG 1. #PPLG #CodingPHP #SchoolVideo',
                'url' => 'https://assets.mixkit.co/videos/preview/mixkit-software-developer-working-on-code-41551-large.mp4',
                'thumb' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&q=80',
                'cat' => $cat_coding,
                'user' => $u_maulana,
                'views' => 1450, 'likes' => 320, 'comments' => 45, 'shares' => 88, 'featured' => true
            ],
            [
                'title' => 'Highlight Class Meeting Futsal XI PPLG vs XI DKV!',
                'description' => 'Keseruan pertandingan final futsal Class Meeting semester ganti! Skor sengit 3-2! #ClassMeeting #PrestasiSiswa #SchoolVideo',
                'url' => 'https://assets.mixkit.co/videos/preview/mixkit-playing-futsal-in-an-indoor-court-41380-large.mp4',
                'thumb' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=600&q=80',
                'cat' => $cat_event,
                'user' => $studentModels[1], // Rangga
                'views' => 2800, 'likes' => 540, 'comments' => 89, 'shares' => 120, 'featured' => true
            ],
            [
                'title' => 'Showcase Motion Graphic 3D Karya Siswa XI DKV 1',
                'description' => 'Hasil karya animasi 3D Blender buatan siswa DKV untuk pameran karya tahunan SMK. #KaryaCreative #DKV #SchoolVideo',
                'url' => 'https://assets.mixkit.co/videos/preview/mixkit-hands-holding-a-smartphone-with-green-screen-41544-large.mp4',
                'thumb' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=600&q=80',
                'cat' => $cat_dkv,
                'user' => $studentModels[5], // Citra
                'views' => 980, 'likes' => 210, 'comments' => 18, 'shares' => 35, 'featured' => true
            ],
            [
                'title' => 'Persiapan Tim LKS Web Technologies SMK Negeri 1 Cirebon',
                'description' => 'Latihan intensif pemecahan soal LKS tingkat Provinsi Jawa Barat 2026. Mohon doanya kawan-kawan! #LKS2026 #PPLG #PrestasiSiswa',
                'url' => 'https://assets.mixkit.co/videos/preview/mixkit-man-working-on-his-laptop-308-large.mp4',
                'thumb' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=80',
                'cat' => $cat_lomba,
                'user' => $studentModels[10], // Hadi
                'views' => 1750, 'likes' => 410, 'comments' => 52, 'shares' => 64, 'featured' => true
            ],
            [
                'title' => 'Penampilan Band Ekstrakurikuler Musik di Pensi Sekolah',
                'description' => 'Cover lagu hits di panggung Pentas Seni tahunan SMK! Suasananya seru banget! #Ekstrakurikuler #SchoolVideo',
                'url' => 'https://assets.mixkit.co/videos/preview/mixkit-a-singer-performing-on-stage-41555-large.mp4',
                'thumb' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&q=80',
                'cat' => $cat_ekskul,
                'user' => $studentModels[9], // Gita
                'views' => 2100, 'likes' => 480, 'comments' => 60, 'shares' => 95, 'featured' => true
            ],
            [
                'title' => 'Penjelasan Algoritma Search & Recommendation Scoring oleh Bu Dian',
                'description' => 'Materi pembelajaran PKWU & PPLG: Bagaimana menghitung Search Score & Recommendation Score pada TikTok & SchoolVideo. #PPLG #SchoolVideo',
                'url' => 'https://assets.mixkit.co/videos/preview/mixkit-teacher-explaining-a-lesson-to-her-students-41539-large.mp4',
                'thumb' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&q=80',
                'cat' => $cat_coding,
                'user' => $u_dian,
                'views' => 3100, 'likes' => 620, 'comments' => 75, 'shares' => 140, 'featured' => true
            ],
        ];

        // Generate 25 additional realistic videos to exceed 30+ total videos
        $extraTitles = [
            'Tips Menguasai Git & GitHub untuk Siswa PPLG',
            'Desain UI/UX Mobile App dengan Figma & Glassmorphism',
            'Praktik Konfigurasi Router & Firewall di Lab TKT',
            'Review Robot Line Follower Buatan Ekskul Robotics',
            'Liputan Kegiatan OSIS: Peringatan Hari Pendidikan',
            'Vlog Sehari Berada di Lab Komputer SMK Negeri 1 Cirebon',
            'Koleksi Foto & Video Dokumentasi PPLG 2026',
            'Behind The Scene Pembuatan Logo & Identitas SchoolVideo',
            'Siswa PPLG Membuat Game 2D Platformer dengan Unity',
            'Tips Menjawab Pertanyaan Presentation Project PKWU',
            'Trik Menghitung HPP dan RAB untuk Project Tender IT',
            'Dokumentasi Kunjungan Industri ke Digital Tech Studio',
            'Demo Aplikasi Bursa Kerja Jobschool & SchoolVideo',
            'Suasana Kantin Digital dan Sistem Pembayaran QRIS Sekolah',
            'Tutorial CSS Tailwind Grid & Flexbox untuk Layout Responsive',
            'Penyerahan Piala Juara 1 LKS Web Technologies 2026',
            'Proses Shooting Short Video Konten Edukasi Kreatif',
            'Kilas Balik Kegiatan E-Sport Mobile Legends Class Meeting',
            'Inovasi Motor Listrik Rakitan Siswa Teknik Otomotif',
            'Wawancara Eksklusif Bersama Kepala Sekolah tentang Smart School',
            'Podcast Alumni: Karir dari Bangku SMK ke Software Engineer',
            'Mengenal Struktur Database Relasional MySQL & ERD',
            'Tutorial Membuat Algoritma Recommendation Engine Sederhana',
            'Rangkuman Fitur Core Wajib SchoolVideo Paket 25',
            'Pesan dan Harapan Guru untuk Kelulusan Angkatan 2027'
        ];

        $allVideoModels = [];

        foreach ($sampleVideos as $sv) {
            $v = Video::create([
                'user_id' => $sv['user']->id,
                'category_id' => $sv['cat']->id,
                'title' => $sv['title'],
                'description' => $sv['description'],
                'video_url' => $sv['url'],
                'thumbnail_url' => $sv['thumb'],
                'duration' => rand(15, 60),
                'views_count' => $sv['views'],
                'likes_count' => $sv['likes'],
                'comments_count' => $sv['comments'],
                'shares_count' => $sv['shares'],
                'is_short' => true,
                'is_featured' => $sv['featured'],
                'is_approved' => true,
            ]);
            $v->hashtags()->attach([$ht_schoolvideo->id, $ht_pplg->id, $ht_prestasi->id]);
            $allVideoModels[] = $v;
        }

        foreach ($extraTitles as $idx => $title) {
            $u = $studentModels[$idx % count($studentModels)];
            $cat = [$cat_coding, $cat_ekskul, $cat_lomba, $cat_event, $cat_dkv][$idx % 5];
            $v = Video::create([
                'user_id' => $u->id,
                'category_id' => $cat->id,
                'title' => $title,
                'description' => $title . ' disajikan oleh ' . $u->name . ' dalam rangka pengerjaan tugas proyek PKWU Smart School. #SchoolVideo #PPLG',
                'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-software-developer-working-on-code-41551-large.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=80',
                'duration' => rand(20, 90),
                'views_count' => rand(200, 1500),
                'likes_count' => rand(30, 250),
                'comments_count' => rand(5, 30),
                'shares_count' => rand(2, 20),
                'is_short' => true,
                'is_featured' => ($idx < 3),
                'is_approved' => true,
            ]);
            $v->hashtags()->attach([$ht_schoolvideo->id, $ht_pplg->id]);
            $allVideoModels[] = $v;
        }

        // 9. Comments (20+ Comments)
        $sampleComments = [
            'Wah keren banget videonya! Penjelasannya sangat jelas dan mudah dipahami.',
            'Mantap mas kodingannya! Ditunggu tutorial bagian Laravelnya.',
            'Semangat tim LKS SMK Negeri 1 Cirebon! Pasti bisa bawa pulang piala!',
            'Visual motion grafisnya aesthetic banget, bangga sama temen-temen DKV!',
            'Penjelasan rumus algoritma bu Dian langsung bikin paham konsep Recommendation Score.',
            'Pertandingan futsal kemarin emang sengit banget, congrats buat XI PPLG 1!',
            'Fitur video pendek SchoolVideo ini smooth banget kayak TikTok asli!',
            'Platform PKWU Paket 25 terintegrasi dengan sempurna. Salut buat developer!',
            'Link source code atau dokumentasinya bisa diakses di mana ya?',
            'Sukses terus buat ekosistem Smart School Social Platform!',
            'Kereeen bgt karya anak SMK zaman sekarang super kreatif!',
            'Bantu share ke grup whatsapp kelas ya guys biar rame videonya!',
            'Design UI dark modenya eye-catching dan enak dilihat mata.'
        ];

        foreach ($allVideoModels as $idx => $v) {
            for ($i = 0; $i < 2; $i++) {
                $u = $studentModels[($idx + $i + 1) % count($studentModels)];
                Comment::create([
                    'user_id' => $u->id,
                    'video_id' => $v->id,
                    'content' => $sampleComments[($idx + $i) % count($sampleComments)],
                ]);
            }
        }

        // 10. Likes (50+ Likes)
        foreach ($allVideoModels as $idx => $v) {
            for ($i = 0; $i < 3; $i++) {
                $u = $studentModels[($idx + $i) % count($studentModels)];
                Like::firstOrCreate([
                    'user_id' => $u->id,
                    'video_id' => $v->id,
                ]);
            }
        }

        // 11. Followers (15+ Follow relationships)
        for ($i = 0; $i < count($studentModels); $i++) {
            $next = ($i + 1) % count($studentModels);
            Follower::firstOrCreate([
                'follower_id' => $studentModels[$i]->id,
                'followed_id' => $studentModels[$next]->id,
            ]);
            Follower::firstOrCreate([
                'follower_id' => $studentModels[$i]->id,
                'followed_id' => $u_dian->id,
            ]);
        }

        // 12. Test Cases (Bab 14 Requirement: Minimal 15 test cases)
        $testCases = [
            ['case_number' => 'TC-001', 'feature' => 'Authentication', 'scenario' => 'Pendaftaran Akun Baru (Register)', 'expected_result' => 'Akun berhasil dibuat, password di-hash, session aktif', 'status' => 'PASSED', 'notes' => 'Input validation & hashing terverifikasi'],
            ['case_number' => 'TC-002', 'feature' => 'Authentication', 'scenario' => 'Login User (Admin/Guru/Siswa)', 'expected_result' => 'User berhasil login dan mengarahkan sesuai role access', 'status' => 'PASSED', 'notes' => 'Role access middleware berfungsi'],
            ['case_number' => 'TC-003', 'feature' => 'Authentication', 'scenario' => 'Logout User', 'expected_result' => 'Session dihancurkan dan mengarahkan kembali ke landing page', 'status' => 'PASSED', 'notes' => 'Session flush teruji'],
            ['case_number' => 'TC-004', 'feature' => 'Profile', 'scenario' => 'Melihat & Mengedit Profil User', 'expected_result' => 'Foto, bio, followers, following, & daftar video tampil akurat', 'status' => 'PASSED', 'notes' => 'CRUD Profil terverifikasi'],
            ['case_number' => 'TC-005', 'feature' => 'Post / Video', 'scenario' => 'Unggah Video Baru (Create Post)', 'expected_result' => 'Video terunggah, thumbnail tergenerasi, hashtag terikat', 'status' => 'PASSED', 'notes' => 'Video upload & validation OK'],
            ['case_number' => 'TC-006', 'feature' => 'Post / Video', 'scenario' => 'Mengubah Data Video (Edit Post)', 'expected_result' => 'Judul, deskripsi, & kategori video berhasil diperbarui', 'status' => 'PASSED', 'notes' => 'Update authorization teruji'],
            ['case_number' => 'TC-007', 'feature' => 'Post / Video', 'scenario' => 'Menghapus Video (Delete Post)', 'expected_result' => 'Video & relasi komentar/like terhapus secara cascade', 'status' => 'PASSED', 'notes' => 'Cascade delete DB terverifikasi'],
            ['case_number' => 'TC-008', 'feature' => 'Social Interaction', 'scenario' => 'Toggle Like pada Video', 'expected_result' => 'Jumlah like bertambah/berkurang secara realtime (AJAX)', 'status' => 'PASSED', 'notes' => 'Count update dynamic'],
            ['case_number' => 'TC-009', 'feature' => 'Social Interaction', 'scenario' => 'Menambah Komentar pada Video', 'expected_result' => 'Komentar muncul di daftar komentar dan menambah total comment', 'status' => 'PASSED', 'notes' => 'AJAX comment submit OK'],
            ['case_number' => 'TC-010', 'feature' => 'Social Interaction', 'scenario' => 'Follow & Unfollow Kreator Video', 'expected_result' => 'Status ikuti berubah & jumlah followers bertambah', 'status' => 'PASSED', 'notes' => 'Social graph relation OK'],
            ['case_number' => 'TC-011', 'feature' => 'Search Engine', 'scenario' => 'Pencarian Video berdasarkan Kata Kunci & Ranking', 'expected_result' => 'Hasil pencarian diurutkan berdasarkan formula Search Score', 'status' => 'PASSED', 'notes' => 'Search Score formula (0.4/0.25/0.2/0.15) applied'],
            ['case_number' => 'TC-012', 'feature' => 'Hashtag', 'scenario' => 'Filter Video berdasarkan Hashtag (#PPLG)', 'expected_result' => 'Menampilkan daftar video yang memiliki tagar terkait', 'status' => 'PASSED', 'notes' => 'Hashtag routing & count OK'],
            ['case_number' => 'TC-013', 'feature' => 'Recommendation', 'scenario' => 'Feed TikTok-style Recommendation (For You)', 'expected_result' => 'Video direkomendasikan berdasarkan skor minat & interaksi', 'status' => 'PASSED', 'notes' => 'Recommendation Engine algorithm applied'],
            ['case_number' => 'TC-014', 'feature' => 'Trending System', 'scenario' => 'Deteksi Konten & Topik Trending', 'expected_result' => 'Konten dengan lonjakan interaksi masuk peringkat trending', 'status' => 'PASSED', 'notes' => 'Trending score formula applied'],
            ['case_number' => 'TC-015', 'feature' => 'UI/UX & Security', 'scenario' => 'Uji Responsive & Security Access Control', 'expected_result' => 'Layout fleksibel di desktop/mobile, input tervalidasi, CSRF terproteksi', 'status' => 'PASSED', 'notes' => 'Responsive check & XSS/CSRF security verified'],
        ];

        foreach ($testCases as $tc) {
            TestCase::create($tc);
        }
    }
}
