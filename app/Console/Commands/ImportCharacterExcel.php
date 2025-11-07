<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Assessment;
use App\Models\AssessmentScore;
use App\Models\User;
use App\Models\Indicator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ImportCharacterExcel extends Command
{
    protected $signature = 'karakita:import-excel {path : Path file Excel (bisa relatif terhadap storage/app)}';
    protected $description = 'Impor nilai karakter (semua sheet) dari Excel ke database';

    public function handle()
    {
        ini_set('memory_limit', '2G');
        gc_enable();

        $path = $this->argument('path');

        // Pastikan path benar
        if (!file_exists($path)) {
            $path = storage_path('app/' . ltrim($path, '/\\'));
        }
        if (!file_exists($path)) {
            $this->error("❌ File tidak ditemukan di: $path");
            return Command::FAILURE;
        }

        // Gunakan streaming reader agar hemat memori
        $reader = IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);
        $sheetNames = $reader->listWorksheetNames($path);

        $this->info("📂 Membuka file: $path");
        $this->info("📑 Terdeteksi " . count($sheetNames) . " sheet: " . implode(', ', $sheetNames));

        $totalStudents = 0;

        // Ambil indikator hanya sekali
        $indicators = Indicator::all()->take(12);
        if ($indicators->count() < 12) {
            $this->warn("⚠️ Jumlah indikator di database kurang dari 12. Tambahkan dulu di tabel indicators.");
        }

        foreach ($sheetNames as $sheetName) {
    $this->line("\n➡️  Memproses sheet: {$sheetName}");

    $reader->setLoadSheetsOnly($sheetName);
    $spreadsheet = $reader->load($path);
    $sheet = $spreadsheet->getActiveSheet();
    $rowIterator = $sheet->getRowIterator();

    $headerSkipped = false;
    $rowCount = 0;

    foreach ($rowIterator as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        $cells = [];

        foreach ($cellIterator as $cell) {
            $cells[] = trim((string)$cell->getValue());
        }

        // Skip header (row 1)
        if (!$headerSkipped) {
            $headerSkipped = true;
            continue;
        }

        $rowCount++;
        $name = $cells[1] ?? null; // kolom B (index 1)
        if (!$name) continue;

        // Ambil skor kolom 3–14 (C–N)
        $scores = array_slice($cells, 2, 12);
        $scores = array_map(fn($v) => (int)($v ?: 0), $scores);

        try {
            DB::beginTransaction();

            $user = User::firstOrCreate(
                ['name' => $name],
                [
                    'email' => strtolower(str_replace(' ', '_', $name)) . '@karakita.id',
                    'password' => bcrypt('password'),
                    'role' => 'siswa'
                ]
            );

            $assessment = Assessment::create([
                'student_id' => $user->id,
                'assessor_id' => 1,
                'source' => 'pengajar',
                'class_name' => trim($sheetName),
                'assessed_at' => Carbon::now(),
            ]);

            foreach ($indicators as $i => $ind) {
                AssessmentScore::create([
                    'assessment_id' => $assessment->id,
                    'indicator_id' => $ind->id,
                    'score' => $scores[$i] ?? 0
                ]);
            }

            DB::commit();
            $totalStudents++;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->warn("⚠️ Gagal memproses {$name} di {$sheetName}: {$e->getMessage()}");
        }

        // Bersihkan memory setiap 100 baris
        if ($rowCount % 100 === 0) {
            gc_collect_cycles();
        }
    }

    $this->info("✅ Sheet {$sheetName} selesai ({$rowCount} siswa)");
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
    gc_collect_cycles();
}


        $this->info("\n📊 Import selesai total: {$totalStudents} siswa dari " . count($sheetNames) . " sheet.");
        return Command::SUCCESS;
    }
}
