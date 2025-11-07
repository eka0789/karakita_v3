<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => 'admin@karakterkita.org'
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        $admin->assignRole('admin');
    }
}
