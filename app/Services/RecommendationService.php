<?php

namespace App\Services;

use App\Models\Recommendation;
use App\Models\PeaceValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RecommendationService
{
    /**
     * Generate rekomendasi otomatis berdasarkan hasil prediksi ML
     */
    public function generate(array $prediction, int $studentId): void
    {
        // Jika tidak ada prediksi valid, hentikan
        if (empty($prediction) || !isset($prediction['features'])) {
            Log::warning("⚠️ Prediction kosong untuk student_id={$studentId}");
            return;
        }

        DB::transaction(function () use ($prediction, $studentId) {
            // 🧹 Hapus rekomendasi lama dari sistem AI
            Recommendation::where('student_id', $studentId)
                ->where('source', 'ai')
                ->delete();

            $label = $prediction['label'] ?? 'Cukup';
            $features = $prediction['features'];

            foreach ($features as $valueName => $score) {
                $peaceValue = PeaceValue::where('name', 'like', "%{$valueName}%")->first();
                if (!$peaceValue) {
                    Log::info("PeaceValue '{$valueName}' tidak ditemukan, dilewati.");
                    continue;
                }

                // Tentukan level numerik (1–5)
                $level = $this->mapScoreToLevel($score);

                // Dapatkan teks rekomendasi
                $description = $this->getRecommendationText($valueName, $score, $label);

                Recommendation::create([
                    'student_id' => $studentId,
                    'peace_value_id' => $peaceValue->id,
                    'level' => $level,
                    'description' => $description,
                    'source' => 'ai',
                    'active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                Log::info("✅ Rekomendasi AI dibuat untuk {$valueName} (score={$score}) student_id={$studentId}");
            }
        });
    }

    /**
     * Mapping skor (1–5) ke level numerik 1–5
     */
    private function mapScoreToLevel(float $score): int
    {
        if ($score < 2) return 1;  // Sangat Rendah
        if ($score < 3) return 2;  // Rendah
        if ($score < 4) return 3;  // Sedang
        if ($score < 4.5) return 4; // Baik
        return 5;                  // Sangat Baik
    }

    /**
     * Teks rekomendasi berdasarkan label dan nilai karakter
     */
    private function getRecommendationText(string $name, float $score, string $label): string
    {
        // Gunakan label global dari hasil prediksi
        $messages = [
            'Perlu Pendampingan Intensif' => "Perlu bimbingan khusus untuk menguatkan nilai {$name}. Fokus pada latihan nyata di kelas.",
            'Perlu Pembinaan' => "Perlu pembinaan lebih lanjut dalam menerapkan nilai {$name}. Disarankan mengikuti kegiatan refleksi karakter.",
            'Cukup' => "Sudah cukup memahami nilai {$name}. Pertahankan dan latih penerapan di kegiatan harian.",
            'Karakter Baik' => "Menunjukkan sikap yang baik dalam {$name}. Pertahankan dan jadilah contoh bagi teman lain.",
            'Karakter Unggul' => "Telah menguasai nilai {$name} dengan sangat baik. Dapat dilibatkan untuk mentoring sebaya.",
        ];

        return $messages[$label] ?? "Perlu pendampingan dalam mengembangkan aspek {$name}.";
    }
}
