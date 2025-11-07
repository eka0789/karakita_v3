<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Assessment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirect user sesuai role-nya
     */
    public function redirect()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'pengajar':
                return redirect()->route('teacher.dashboard');
            case 'orangtua':
                return redirect()->route('parent.dashboard');
            case 'siswa':
                return redirect()->route('student.dashboard');
            default:
                return redirect('/login')->with('error', 'Role tidak dikenali.');
        }
    }

    /**
     * Dashboard untuk Admin
     */
    public function admin(Request $request)
{
    $totalSiswa = User::where('role', 'siswa')->count();
    $totalGuru  = User::where('role', 'pengajar')->count();
    $totalOrangtua = User::where('role', 'orangtua')->count();
    $totalPenilaian = Assessment::count();

    // Ambil collection per role — kita kirim ke view agar blade lebih rapi
    $teachers = User::where('role', 'pengajar')->orderBy('name')->get();
    $students = User::where('role', 'siswa')->orderBy('name')->get();
    $parents  = User::where('role', 'orangtua')->orderBy('name')->get();

    $tab = $request->tab ?? 'guru';
    $search = $request->search;

    $teachers = User::where('role','pengajar')
                    ->when($search && $tab=='guru', fn($q)=>$q->where('name','LIKE',"%$search%"))
                    ->orderBy('name')->get();

    $students = User::where('role','siswa')
                    ->when($search && $tab=='siswa', fn($q)=>$q->where('name','LIKE',"%$search%"))
                    ->orderBy('name')->get();

    $parents = User::where('role','orangtua')
                    ->when($search && $tab=='orangtua', fn($q)=>$q->where('name','LIKE',"%$search%"))
                    ->orderBy('name')->get();

    return view('dashboard.admin', compact(
        'totalSiswa',
        'totalGuru',
        'totalOrangtua',
        'totalPenilaian',
        'teachers',
        'students',
        'parents'
    ));
}


    /**
     * Dashboard untuk Pengajar (Guru)
     */
    public function teacher()
    {
        $students = User::where('role', 'siswa')
            ->with(['assessments' => fn($q) => $q->withCount('scores')])
            ->get();

        $data = $students->map(function ($student) {
            $latest = $student->assessments->sortByDesc('assessed_at')->first();

            $avgScore = DB::table('assessment_scores')
                ->join('assessments', 'assessment_scores.assessment_id', '=', 'assessments.id')
                ->where('assessments.student_id', $student->id)
                ->avg('assessment_scores.score');

            return [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'class_name' => $latest?->class_name ?? '-',
                // ✅ Selalu float
                'avg_score' => (float) round($avgScore ?? 0, 2),
                'assessments_count' => $student->assessments->count(),
                // ✅ Tanggal diformat aman
                'last_assessed' => $latest?->assessed_at
                    ? \Carbon\Carbon::parse($latest->assessed_at)->format('d M Y')
                    : '-',
            ];
        });

        return view('dashboard.teacher', compact('data'));
    }

    /**
     * Dashboard untuk Orang Tua
     */
    public function parent()
{
    $user = Auth::user();

    // Ambil seluruh anak
    $children = $user->children()->orderBy('name')->get();

    // Ambil pred & rekom per anak
    $ml = app(\App\Services\ML\CharacterRFService::class);

    $childrenData = $children->map(function($c) use ($ml) {
        $pred = $ml->predictStudent($c->id);

        return [
            'id' => $c->id,
            'name' => $c->name,
            'class' => $c->classroom ?? '-',
            'prediction' => $pred,
            'recommendations' => $pred
                ? $c->recommendations()->with('peaceValue')->orderBy('level','desc')->get()
                : collect(),
        ];
    });

    $modules = \App\Models\LearningModule::inRandomOrder()->limit(3)->get();

    return view('dashboard.parent', compact('user', 'childrenData', 'modules'));
}


    /**
     * Dashboard untuk Siswa
     */
    public function student()
{
    $user = Auth::user();

    // Ambil semua penilaian siswa
    $assessments = Assessment::where('student_id', $user->id)
        ->with('scores.indicator.peaceValue')
        ->orderBy('assessed_at', 'asc')
        ->get();

    // Hitung rata-rata keseluruhan
    $avg = $assessments->flatMap->scores->avg('score') ?? 0;

    // --- Tambahan Integrasi ML ---
    $ml = app(\App\Services\ML\CharacterRFService::class);
    $prediction = $ml->predictStudent($user->id);

    // --- Rekomendasi otomatis ---
    $recommendations = $user->recommendations()
        ->with('peaceValue')
        ->orderBy('level', 'desc')
        ->get();

    // --- Modul pembelajaran terkait (opsional)
    $modules = \App\Models\LearningModule::orderBy('id')->get();

    // --- Grafik rata-rata per penilaian ---
    $chartLabels = $assessments->map(fn($a) => \Carbon\Carbon::parse($a->assessed_at)->format('d M'));
    $chartValues = $assessments->map(fn($a) => round($a->scores->avg('score'), 2));

    return view('dashboard.student', compact(
        'user',
        'assessments',
        'avg',
        'prediction',
        'recommendations',
        'modules',
        'chartLabels',
        'chartValues'
    ));
}

}
