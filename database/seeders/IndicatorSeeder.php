<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeaceValue;
use App\Models\Indicator;

class IndicatorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Menerima Diri' => [
                'Guru' => 'Siswa menunjukkan rasa percaya diri dan menerima kelebihan serta kekurangannya.',
                'OrangTua' => 'Siswa tidak membandingkan diri dengan orang lain dan mensyukuri diri sendiri.'
            ],
            'Memahami Prasangka' => [
                'Guru' => 'Siswa menilai teman berdasarkan perilaku, bukan asumsi atau gosip.',
                'OrangTua' => 'Siswa tidak cepat menuduh atau menilai tanpa bukti nyata.'
            ],
            'Perbedaan Etnis / Suku' => [
                'Guru' => 'Siswa menghormati teman berbeda latar belakang dan tidak mengejek suku/ras.',
                'OrangTua' => 'Siswa menghargai orang dengan perbedaan budaya, bahasa, atau kebiasaan.'
            ],
            'Perbedaan Agama' => [
                'Guru' => 'Siswa menghormati teman yang berbeda agama dan tidak memaksakan keyakinan.',
                'OrangTua' => 'Siswa toleran terhadap perbedaan ibadah atau perayaan agama lain.'
            ],
            'Perbedaan Gender' => [
                'Guru' => 'Siswa menghormati teman laki-laki maupun perempuan secara setara.',
                'OrangTua' => 'Siswa memahami bahwa tugas rumah tangga atau kepemimpinan bisa dilakukan siapa saja.'
            ],
            'Perbedaan Status Ekonomi' => [
                'Guru' => 'Siswa bersikap adil dan tidak membeda-bedakan berdasarkan kemampuan ekonomi.',
                'OrangTua' => 'Siswa menghargai teman dari latar belakang ekonomi berbeda tanpa merasa lebih tinggi/rendah.'
            ],
            'Perbedaan Kelompok / Geng' => [
                'Guru' => 'Siswa mau bergaul dengan semua teman, tidak eksklusif terhadap kelompok tertentu.',
                'OrangTua' => 'Siswa mau aktivitas dengan teman di luar kelompok tetapnya.'
            ],
            'Memahami Perbedaan' => [
                'Guru' => 'Siswa menunjukkan sikap toleransi dan menghargai pendapat orang lain.',
                'OrangTua' => 'Siswa mau mendengarkan pandangan orang lain meskipun berbeda.'
            ],
            'Mengatasi Konflik' => [
                'Guru' => 'Siswa mampu berdamai setelah berselisih dan mencari solusi damai.',
                'OrangTua' => 'Siswa menahan emosi dan menyelesaikan masalah tanpa kekerasan.'
            ],
            'Menolak Kekerasan' => [
                'Guru' => 'Siswa menyelesaikan masalah dengan dialog, bukan tindakan kasar.',
                'OrangTua' => 'Siswa tidak melakukan kekerasan fisik atau verbal.'
            ],
            'Mengakui Kesalahan' => [
                'Guru' => 'Siswa berani mengaku salah dan memperbaiki kesalahan.',
                'OrangTua' => 'Siswa bertanggung jawab atas kesalahan dan jujur di rumah.'
            ],
            'Memberi Maaf' => [
                'Guru' => 'Siswa bersedia memaafkan teman yang bersalah.',
                'OrangTua' => 'Siswa tidak menyimpan dendam dan memperbaiki hubungan setelah berselisih.'
            ]
        ];

        foreach ($data as $pv => $descriptions) {
            $value = PeaceValue::where('name',$pv)->first();
            if (!$value) continue;

            Indicator::create([
                'peace_value_id' => $value->id,
                'description_school' => $descriptions['Guru'],
                'description_home' => $descriptions['OrangTua']
            ]);
        }
    }
}
