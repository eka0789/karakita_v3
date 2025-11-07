<?php

namespace App\Services\ML;

use Phpml\Classification\Ensemble\RandomForest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Assessment;
use App\Models\PeaceValue;
use Carbon\Carbon;

class CharacterRFService
{
    private string $modelPath = 'ml/model_rf.serialized';

    /**
     * Bangun fitur: rata-rata skor per peace value untuk setiap siswa.
     *
     * @return array [samples, labels, featureNames]
     */
    private function buildFeatures(): array
    {
        $peaceValues = PeaceValue::pluck('name')->toArray();
        $students = Assessment::select('student_id')->distinct()->pluck('student_id');

        $samples = [];
        $labels  = [];

        foreach ($students as $sid) {
            $scores = Assessment::where('student_id', $sid)
                ->with('scores.indicator.peaceValue')
                ->get()
                ->flatMap(fn($a) => $a->scores)
                ->groupBy(fn($s) => $s->indicator->peaceValue->name)
                ->map(fn($g) => round($g->avg('score'), 2))
                ->toArray();

            // Gunakan semua PeaceValue agar urutan konsisten
            $vector = [];
            foreach ($peaceValues as $pv) {
                $vector[] = $scores[$pv] ?? 0;
            }

            if (array_sum($vector) === 0) {
                continue; // skip siswa tanpa data
            }

            $samples[] = $vector;
            $avg = array_sum($vector) / count($vector);
            $labels[] = $this->generateLabel($avg);
        }

        Log::info("🔢 Dataset ML: " . count($samples) . " siswa dengan " . count($peaceValues) . " fitur.");

        return [$samples, $labels, $peaceValues];
    }

    /**
     * Hasilkan label dummy untuk supervised training
     */
    private function generateLabel(float $avg): string
    {
        if ($avg >= 4) return 'Baik';
        if ($avg >= 3) return 'Cukup';
        return 'Perlu Perhatian';
    }

    /**
     * Latih model Random Forest dan simpan ke storage
     */
    public function train(): void
    {
        [$samples, $labels] = $this->buildFeatures();

        if (empty($samples)) {
            Log::warning("⚠️ Tidak ada data yang cukup untuk melatih model Random Forest.");
            return;
        }

        try {
            $rf = new RandomForest(100, 3); // 100 pohon, 3 fitur acak per split
            $rf->train($samples, $labels);

            // Pastikan folder penyimpanan ada
            Storage::makeDirectory('ml');

            // Simpan model
            Storage::put($this->modelPath, serialize($rf));

            Log::info("✅ Model Random Forest berhasil dilatih dan disimpan ke: {$this->modelPath}");
        } catch (\Throwable $e) {
            Log::error("❌ Gagal melatih model: " . $e->getMessage());
        }
    }

    /**
     * Prediksi perkembangan karakter satu siswa
     */
    public function predictStudent(int $studentId): ?array
    {
        if (!Storage::exists($this->modelPath)) {
            Log::warning("⚠️ Model RF belum ada di {$this->modelPath}. Jalankan train() terlebih dahulu.");
            return null;
        }

        try {
            $rf = unserialize(Storage::get($this->modelPath));
            if (!$rf instanceof RandomForest) {
                throw new \Exception("File model tidak valid atau corrupt.");
            }
        } catch (\Throwable $e) {
            Log::error("❌ Gagal load model RF: " . $e->getMessage());
            return null;
        }

        $peaceValues = PeaceValue::pluck('name')->toArray();

        // Ambil skor siswa
        $scores = Assessment::where('student_id', $studentId)
            ->with('scores.indicator.peaceValue')
            ->get()
            ->flatMap(fn($a) => $a->scores)
            ->groupBy(fn($s) => $s->indicator->peaceValue->name)
            ->map(fn($g) => round($g->avg('score'), 2))
            ->toArray();

        if (empty($scores)) {
            Log::info("⚠️ Tidak ada skor untuk siswa ID {$studentId}");
            return null;
        }

        // Buat vektor sesuai urutan peace values
        $vector = [];
        foreach ($peaceValues as $pv) {
            $vector[] = $scores[$pv] ?? 0;
        }

        $pred = $rf->predict($vector);
        $avg = round(array_sum($vector) / count($vector), 2);

        return [
            'label' => $pred,
            'avg' => $avg,
            'features' => $scores,
            'timestamp' => Carbon::now()->toDateTimeString(),
        ];
    }
}
