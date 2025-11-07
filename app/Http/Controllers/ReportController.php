<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Assessment;
use App\Models\PeaceValue;
use App\Services\ML\CharacterRFService;
use App\Services\RecommendationService;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    /**
     * 🔹 Laporan detail perkembangan karakter
     * Role yang diizinkan:
     * ✅ Pengajar
     * ✅ Orangtua (hanya anak sendiri)
     * ❌ Admin → Redirect ke daftar global
     * ❌ Siswa → Dilarang akses
     */
    public function show(
    int $studentId,
    CharacterRFService $ml,
    RecommendationService $reco
) {
    $student = User::findOrFail($studentId);
    $auth = Auth::user();

    // Access control
    if ($auth->hasRole('siswa')) abort(403, 'Akses ditolak');
    if ($auth->hasRole('orangtua') && $auth->id !== $student->parent_id)
        abort(403, 'Akses ditolak');
    if ($auth->hasRole('admin')) {
        return redirect()->route('admin.reports.index')
            ->with('warning', 'Admin hanya dapat melihat laporan global');
    }

    // Load assessments
    $assessments = Assessment::where('student_id', $studentId)
        ->with('scores.indicator.peaceValue')
        ->orderBy('assessed_at')
        ->get();

    // =============================
    // Latest scoring (Radar Chart)
    // =============================
    $latest = $assessments->last();
    $indicators = $latest?->scores->map(
        fn($s) => $s->indicator->peaceValue->name
    )->toArray() ?? [];
    $scores = $latest?->scores->map(
        fn($s) => (float) $s->score
    )->toArray() ?? [];

    // =============================
    // Grafik Line Tren Perkembangan
    // =============================
    $filterPv = request()->get('value'); // peace_value_id filter

    $chart = $assessments->groupBy(
        fn($a) => Carbon::parse($a->assessed_at)->format('M Y')
    )->map(function($group) use ($filterPv) {
        $scores = $group->flatMap->scores;

        if ($filterPv) {
            $scores = $scores->filter(
                fn($s) => $s->indicator->peaceValue->id == $filterPv
            );
        }

        return round($scores->avg('score'), 2);
    });

    // Delta perkembangan
    $current = $chart->values()->last();
    $previous = $chart->values()->slice(-2, 1)->first();
    $delta = $previous ? $current - $previous : 0;

    // ML Prediction + rekomendasi
    $prediction = $ml->predictStudent($studentId);
    if ($prediction) $reco->generate($prediction, $studentId);

    $recommendations = $student->recommendations()
        ->with('peaceValue')
        ->orderBy('level', 'desc')
        ->get();

    return view('reports.show', [
        'student' => $student,
        'assessments' => $assessments,
        'indicators' => $indicators,  // ✅ radar chart fix
        'scores' => $scores,          // ✅ radar chart fix
        'chartLabels' => $chart->keys(),
        'chartValues' => $chart->values(),
        'delta' => $delta,
        'prediction' => $prediction,
        'recommendations' => $recommendations,
        'peaceValues' => PeaceValue::orderBy('order')->get(), // ✅ filter dropdown
        'filter' => $filterPv,
    ]);
}


    /**
     * 🔹 Laporan global untuk:
     * ✅ Admin (overview)
     * ✅ Pengajar (daftar siswa bimbingannya)
     */
    public function index(CharacterRFService $ml)
    {
        $students = User::role('siswa')->with('latestAssessment')->get();

        $reports = $students->map(function ($student) use ($ml) {
            $pred = $ml->predictStudent($student->id);
            return [
                'id' => $student->id,
                'name' => $student->name,
                'avg' => $pred['avg'] ?? null,
                'label' => $pred['label'] ?? '-',
                'updated_at' => optional($student->latestAssessment)->assessed_at,
            ];
        });

        return view('reports.index', compact('reports'));
    }

    /**
     * 🔹 Orangtua lihat laporan anaknya
     */
    public function showParent(int $childId, CharacterRFService $ml)
    {
        abort_unless(Auth::user()->hasRole('orangtua'), 403);
        return $this->show($childId, $ml, app(RecommendationService::class));
    }

   public function exportPdf(
    int $studentId,
    CharacterRFService $ml,
    RecommendationService $reco
) {
    $auth = Auth::user();
    $student = User::findOrFail($studentId);

    // ✅ Izinkan admin & pengajar tanpa batasan
    if ($auth->hasAnyRole(['admin', 'pengajar'])) {
        // lanjut tanpa pembatasan
    }
    // ✅ Orang tua hanya bisa lihat anaknya
    elseif ($auth->hasRole('orangtua') && $auth->id !== $student->parent_id) {
        abort(403, 'Akses ditolak: bukan orang tua siswa ini');
    }
    // ✅ Siswa hanya bisa lihat dirinya sendiri
    elseif ($auth->hasRole('siswa') && $auth->id !== $student->id) {
        abort(403, 'Akses ditolak: siswa hanya dapat lihat laporan diri sendiri');
    }

    // ✅ Fetch data lengkap
    $assessments = Assessment::where('student_id', $studentId)
        ->with('scores.indicator.peaceValue')
        ->orderBy('assessed_at')
        ->get();

    if ($assessments->isEmpty()) {
        return back()->with('warning', 'Belum ada data penilaian untuk siswa ini');
    }

    // ✅ Prediksi + update rekomendasi
    $prediction = $ml->predictStudent($studentId);
    if ($prediction) $reco->generate($prediction, $studentId);

    // ✅ Generate PDF resmi KarakterKita
    $pdf = PDF::loadView('reports.pdf', [
        'student' => $student,
        'prediction' => $prediction,
        'assessments' => $assessments,
    ])->setPaper('A4', 'portrait');

    return $pdf->download('Laporan-Karakter-'.$student->name.'.pdf');
}

}
