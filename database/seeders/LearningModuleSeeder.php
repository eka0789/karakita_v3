<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PeaceValue;

class LearningModuleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan nilai dasar perdamaian sudah ada
        $peaceValues = PeaceValue::pluck('id', 'name');

        // Mapping nilai → peace_value_id (fallback: id pertama)
        $getId = fn($name) => $peaceValues[$name] ?? $peaceValues->first();

        $modules = [

            // === 🎬 VIDEO PEMBELAJARAN ===
            [
                'peace_value_id' => $getId('Berpikir Kritis'),
                'title' => 'Animasi: Beberapa Kesalahan Berpikir (Logical Fallacy)',
                'type' => 'video',
                'description' => 'Video animasi tentang berbagai kesalahan berpikir logis yang melatih kemampuan berpikir kritis.',
                'url' => 'https://youtu.be/TKqbAgR86QE?list=PL1qTNaePw9Bhwm-Wz68rS0SYxM1Nc1Jb_',
            ],
            [
                'peace_value_id' => $getId('Keadilan'),
                'title' => 'PPKn - 1: Jenis Kekuasaan Indonesia',
                'type' => 'video',
                'description' => 'Pembelajaran PPKn tentang jenis kekuasaan dan penerapan nilai keadilan di Indonesia.',
                'url' => 'https://youtu.be/kMCgTnqtRP0?list=PL1qTNaePw9Bh8eBXAV3rJkMl9SviI7cDy',
            ],
            [
                'peace_value_id' => $getId('Menghargai Perbedaan'),
                'title' => 'Prasangka - Akibat Curiga (#MeyakiniMenghargai)',
                'type' => 'video',
                'description' => 'Belajar tentang bahaya prasangka dan cara membangun empati lintas perbedaan.',
                'url' => 'https://youtu.be/i5kp2NTU4QE?list=PL1qTNaePw9Bgui5D_b3pI2lT6nL60qmWI',
            ],
            [
                'peace_value_id' => $getId('Menyelesaikan Konflik'),
                'title' => 'Menyelesaikan Konflik Tanpa Kekerasan',
                'type' => 'video',
                'description' => 'Pembelajaran cara menyelesaikan konflik dengan komunikasi damai.',
                'url' => 'https://youtu.be/hQMmNZ1yGV8?list=PL1qTNaePw9BiQqGQf7ig-qcgjduodzTTJ',
            ],
            [
                'peace_value_id' => $getId('Kasih'),
                'title' => 'PAK - 2: Animasi Belajar Pada Dandelion',
                'type' => 'video',
                'description' => 'Animasi inspiratif tentang ketekunan, kasih, dan pengampunan.',
                'url' => 'https://youtu.be/H6Tf0-UOj6k?list=PL1qTNaePw9Bjs0WSe7qHni4Z60g1p2tMW',
            ],
            [
                'peace_value_id' => $getId('Kreativitas'),
                'title' => 'Cara Menyelesaikan Konflik Dengan Simpang Sembilan',
                'type' => 'video',
                'description' => 'Pendekatan kreatif dalam menyelesaikan konflik dengan metode Simpang Sembilan.',
                'url' => 'https://youtu.be/6wO21xf5Q2U?list=PL1qTNaePw9BjBhRpVpcy9JiCiDnVtZw4l',
            ],
            [
                'peace_value_id' => $getId('Keadilan Sosial'),
                'title' => 'Kaya dan Miskin: Perbedaan Status Ekonomi',
                'type' => 'video',
                'description' => 'Refleksi tentang kesetaraan dan empati terhadap perbedaan ekonomi.',
                'url' => 'https://youtu.be/0fadQqgIFnU?list=PL1qTNaePw9BipsEOHlsJSlc1XFd3oVCKt',
            ],
            [
                'peace_value_id' => $getId('Kerendahan Hati'),
                'title' => 'Animasi Inspiratif: Begini Caranya Meminta Maaf (Rumus SELAMAAT)',
                'type' => 'video',
                'description' => 'Menumbuhkan kerendahan hati melalui kebiasaan meminta maaf dengan tulus.',
                'url' => 'https://youtu.be/HxRvYhBJt5A?list=PL1qTNaePw9BgVHMZG3wdafd6gmJTb04GU',
            ],

            // === 🎧 PODCAST KARAKTER ===
            [
                'peace_value_id' => $getId('Nasionalisme'),
                'title' => 'Podcast PPKn - Ancaman Ideologi Indonesia',
                'type' => 'video',
                'description' => 'Podcast tentang pentingnya menjaga ideologi bangsa di tengah arus globalisasi.',
                'url' => 'https://youtu.be/1b1U_5AmdXQ?si=cOt9xy4xdR4NQNfH',
            ],
            [
                'peace_value_id' => $getId('Iman'),
                'title' => 'Podcast PAI - Kisah 3 Pemuda yang Terjebak di Dalam Gua',
                'type' => 'video',
                'description' => 'Kisah spiritual tentang keteguhan iman dalam menghadapi ujian hidup.',
                'url' => 'https://youtu.be/uWhuidiPiCw?si=K4rrCCQ44bqykQrY',
            ],
            [
                'peace_value_id' => $getId('Kesabaran'),
                'title' => 'Podcast BK - Rumus BTS (Bersyukur, Tulus, Sabar)',
                'type' => 'video',
                'description' => 'Podcast pembentukan karakter positif dengan prinsip Bersyukur, Tulus, dan Sabar.',
                'url' => 'https://youtu.be/P6nP0NO4eho?si=V0pWVYSaqP1bR_Dx',
            ],
            [
                'peace_value_id' => $getId('Menyelesaikan Konflik'),
                'title' => 'Podcast BK - 5 Tips Hadapi Konflik',
                'type' => 'video',
                'description' => 'Langkah praktis menghadapi konflik dengan tenang dan damai.',
                'url' => 'https://youtu.be/eh5HUf4SZeA?si=h5WlknH6zs0vAf5W',
            ],
            [
                'peace_value_id' => $getId('Kasih'),
                'title' => 'Podcast PAK - Yesus Teladan Untuk Kita Semua',
                'type' => 'video',
                'description' => 'Refleksi kasih dan pengampunan dari teladan Yesus Kristus.',
                'url' => 'https://youtu.be/n2cmiBBC9k0?si=dQYG-GHSP1wcOi8e',
            ],
            [
                'peace_value_id' => $getId('Menghargai Perbedaan'),
                'title' => 'Podcast: Nilai 4 – Beda Keyakinan Nggak Musuhan',
                'type' => 'video',
                'description' => 'Belajar menghormati perbedaan keyakinan tanpa konflik dan kebencian.',
                'url' => 'https://youtu.be/uWhuidiPiCw?si=w60lLLQCNPBbueVn',
            ],
            [
                'peace_value_id' => $getId('Berpikir Positif'),
                'title' => 'Podcast: Nilai 2 – No Curiga No Prasangka',
                'type' => 'video',
                'description' => 'Belajar berpikir positif dan menghindari prasangka buruk.',
                'url' => 'https://youtu.be/nZ3yjkhG41c?si=GsoStdZ33c9otI5O',
            ],
            [
                'peace_value_id' => $getId('Menghargai Diri dan Orang Lain'),
                'title' => 'Podcast: Nilai 8 – Semua Istimewa Semua Berharga',
                'type' => 'video',
                'description' => 'Podcast reflektif tentang menghargai setiap individu.',
                'url' => 'https://youtu.be/hnLtaI5hBp0?si=os2UjOHR607pjTeQ',
            ],

            // === 📘 MODUL PELENGKAP ===
            [
                'peace_value_id' => $getId('Kemandirian'),
                'title' => 'Modul Pembelajaran Karakter RCK',
                'type' => 'artikel',
                'description' => 'Kumpulan materi Character Building dari Rumah Cerdas KITA.',
                'url' => 'https://drive.google.com/drive/folders/1CgWm0sNQc3vjIdVxgWmP1Es3v9u6Ugrl?usp=sharing',
            ],
        ];

        DB::table('learning_modules')->insert($modules);
    }
}
