<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            ClassroomSeeder::class,
            PeaceValueSeeder::class,
            IndicatorSeeder::class,
            SampleDataSeeder::class, // Opsional bisa di-comment 
            UserSeeder::class,
            LearningModuleSeeder::class,
            // jika sudah production
        ]);
    }
}
