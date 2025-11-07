<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recommendation;

class RecommendationSeeder extends Seeder
{
    public function run(): void
    {
        Recommendation::create([
            'student_id' => 1,
            'peace_value_id' => 1,
            'level' => 3,
            'description' => 'Perlu meningkatkan kerja sama dalam kelompok.',
            'source' => 'ai',
            'active' => true,
        ]);
    }
}
