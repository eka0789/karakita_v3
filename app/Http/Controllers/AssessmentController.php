<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Assessment,
    AssessmentScore,
    PeaceValue,
    Indicator,
    User,
    Classroom
};
use App\Services\ML\CharacterRFService;
use App\Services\RecommendationService;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    /**
     * List penilaian oleh guru
     */
    public function index()
    {
        $assessments = Assessment::with('student')
            ->where('assessor_id', auth()->id())
            ->latest()
            ->get();

        return view('assessments.index', compact('assessments'));
    }

    /**
     * Form Create Manual
     */
    public function create()
{
    $user = auth()->user();
    $role = $user->hasRole('pengajar') ? 'teacher' : 'parent';

    // Ambil 12 Nilai Perdamaian & indikator
    $values = \App\Models\PeaceValue::with('indicators')->orderBy('id')->get();

    if ($role === 'teacher') {
        // Bisa disaring ke siswa di kelas yang dia ampu bila ada relasi
        $students = \App\Models\User::where('role', 'siswa')
                    ->orderBy('name')
                    ->get(['id','name']);
        return view('assessments.create', compact('role', 'values', 'students'));
    } else {
        // Orang tua: ambil anak-anaknya
        $children = $user->children()->orderBy('name')->get(['id','name']);
        // Opsional: auto-pilih anak pertama
        $student  = $children->first(); // atau null bila ingin selalu pakai dropdown
        return view('assessments.create', compact('role', 'values', 'children', 'student'));
    }
}

    /**
     * Store manual assessment
     */
    public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:users,id',
        'assessed_at' => 'required|date',
        'scores' => 'required|array'
    ]);

    $assessment = Assessment::create([
        'student_id' => $request->student_id,
        'assessor_id' => auth()->id(),
        'assessed_at' => $request->assessed_at,
    ]);

    foreach($request->scores as $indicator_id => $score){
        AssessmentScore::create([
            'assessment_id' => $assessment->id,
            'indicator_id' => $indicator_id,
            'score' => $score,
        ]);
    }

    return redirect()->back()->with('success','✅ Penilaian berhasil disimpan!');
}


    /**
     * Show single assessment
     */
    public function show(Assessment $assessment)
    {
        $assessment->load('scores.indicator.peaceValue', 'student');
        return view('assessments.show', compact('assessment'));
    }

    /**
     * Import Penilaian Excel — khusus Admin
     */
    public function importExcel(Request $request, CharacterRFService $ml, RecommendationService $reco)
{
    $request->validate([
        'excel_file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $rows = Excel::toArray([], $request->file('excel_file'));
    $rows = $rows[0] ?? [];

    if (empty($rows)) {
        return back()->with('error', '❌ File Excel kosong atau tidak terbaca.');
    }

    // ✅ Normalisasi header → lowercase dan trim
    $header = collect($rows[0])->map(fn($h) => strtolower(trim($h)))->toArray();

    // ✅ Pastikan email siswa wajib
    if (!in_array('student_email', $header)) {
        return back()->with('error', '❌ Kolom "student_email" wajib ada!');
    }

    $indicators = Indicator::with('peaceValue')->get();
    $count = 0;

    foreach (array_slice($rows, 1) as $row) {
        $data = @array_combine($header, $row);
        if (!$data) continue;

        // ✅ Cari siswa berdasarkan email
        $email = strtolower(trim($data['student_email']));
        $student = User::where('email', $email)
            ->where('role', 'siswa')
            ->first();

        if (!$student) continue;

        // ✅ Auto set kelas jika ada
        if (!empty($data['class_name'])) {
            $classroom = Classroom::firstOrCreate([
                'name' => trim($data['class_name'])
            ]);
            $student->update(['classroom_id' => $classroom->id]);
        }

        // ✅ Fix tanggal penilaian (Excel number → tanggal)
        $assessedAt = now();
        if (!empty($data['tanggal_penilaian'])) {
            try {
                $assessedAt = ExcelDate::excelToDateTimeObject($data['tanggal_penilaian'])
                    ->format('Y-m-d');
            } catch (\Throwable) {
                // fallback ke today
            }
        }

        $assessment = Assessment::create([
            'student_id'  => $student->id,
            'assessor_id' => auth()->id(),
            'class_name'  => $student->classroom->name ?? '-',
            'source'      => 'excel',
            'assessed_at' => $assessedAt
        ]);

        // ✅ Insert semua indicator score
        foreach ($indicators as $indicator) {
            $col = strtolower(trim($indicator->peaceValue->name));
            if (isset($data[$col]) && is_numeric($data[$col])) {
                AssessmentScore::create([
                    'assessment_id' => $assessment->id,
                    'indicator_id' => $indicator->id,
                    'score' => (float) $data[$col],
                ]);
            }
        }

        // ✅ Generate rekomendasi
        $pred = $ml->predictStudent($student->id);
        if ($pred) {
            $reco->generate($pred, $student->id);
        }

        $count++;
    }

    // ✅ Train ulang ML sekali, setelah semua selesai
    if ($count > 0) {
        $ml->train();
    }

    return redirect()->route('admin.dashboard')
        ->with('success', "✅ Import sukses! {$count} penilaian diproses & AI diperbarui 🤖🎯");
}

}
