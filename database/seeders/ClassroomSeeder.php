<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['TK1', 'TK2', 'KLS1', 'KLS2', 'KLS3', 'KLS4', 'KLS5', 'KLS6'];

        foreach ($names as $name) {
            Classroom::firstOrCreate(['name' => $name]);
        }
    }
}
