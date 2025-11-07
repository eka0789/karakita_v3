<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeaceValue;

class PeaceValueSeeder extends Seeder
{
    public function run(): void
    {
        $values = [
            'Menerima Diri','Memahami Prasangka','Perbedaan Etnis / Suku',
            'Perbedaan Agama','Perbedaan Gender','Perbedaan Status Ekonomi',
            'Perbedaan Kelompok / Geng','Memahami Perbedaan',
            'Mengatasi Konflik','Menolak Kekerasan','Mengakui Kesalahan','Memberi Maaf'
        ];

        foreach ($values as $i => $v) {
            PeaceValue::create(['name' => $v, 'order' => $i + 1]);
        }
    }
}
