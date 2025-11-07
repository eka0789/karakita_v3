<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Classroom;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $parent = User::firstOrCreate([
            'email' => 'parent@karakterkita.org'
        ], [
            'name' => 'Orang Tua Contoh',
            'password' => Hash::make('password'),
            'role' => 'orangtua'
        ]);
        $parent->assignRole('orangtua');

        $guru = User::firstOrCreate([
            'email' => 'guru@karakterkita.org'
        ], [
            'name' => 'Guru Contoh',
            'password' => Hash::make('password'),
            'role' => 'pengajar'
        ]);
        $guru->assignRole('pengajar');

        $kelas = Classroom::first();

        $siswa = User::firstOrCreate([
            'email' => 'siswa@karakterkita.org'
        ], [
            'name' => 'Siswa Contoh',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'classroom_id' => $kelas?->id,
            'parent_id' => $parent->id
        ]);
        $siswa->assignRole('siswa');
    }
}
