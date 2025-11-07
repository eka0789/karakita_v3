<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    AssessmentController,
    ReportController,
    PeaceValueController,
    ReflectionController,
    UserController,
    ProfileController
};

// =======================
// 🔹 LANDING PAGE
// =======================
Route::get('/', fn() => view('welcome'));

// =======================
// 🔹 AUTENTIKASI WAJIB
// =======================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Redirect role-aware dashboard
    Route::get('/redirect', [DashboardController::class, 'redirect'])->name('redirect');

    // =======================
    // 🔸 ADMIN AREA
    // =======================
    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // Manajemen Pengguna
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Master Data Nilai Perdamaian
        Route::resource('peacevalues', PeaceValueController::class);

        Route::get('/import', [UserController::class, 'importView'])->name('import.index');
        Route::post('/import', [UserController::class, 'importExcel'])->name('import.store');
        Route::get('/import/template/{role}', [UserController::class, 'downloadTemplate'])->name('import.template');


        // Laporan Umum (semua siswa)
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{student}', [ReportController::class, 'show'])->name('reports.show');
        Route::post('/assessments/import', [AssessmentController::class, 'importExcel'])->name('assessments.import');
        Route::get('/samples/template_penilaian.xlsx', function () {
    $file = public_path('samples/template_penilaian.xlsx');
    if (!file_exists($file)) {
        abort(404, 'Template belum tersedia');
    }
    return response()->download($file, 'template_penilaian.xlsx');
})->name('template.penilaian.download');


    });

   // =======================
// 🔸 PENGAJAR AREA
// =======================
Route::middleware('role:pengajar')->prefix('pengajar')->as('teacher.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'teacher'])->name('dashboard');

    Route::get('/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');
    Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');

    // ✅ Laporan per siswa
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{student}', [ReportController::class, 'show'])->name('reports.show');
});


    // =======================
    // 🔸 ORANGTUA AREA
    // =======================
    Route::middleware('role:orangtua')->prefix('orangtua')->as('parent.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'parent'])->name('dashboard');

        // Laporan perkembangan anak
        Route::get('/reports/{child}', [ReportController::class, 'showParent'])->name('reports.show');
        Route::get('/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');
        Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');

    });

    // =======================
    // 🔸 SISWA AREA
    // =======================
    Route::middleware('role:siswa')->prefix('siswa')->as('student.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'student'])->name('dashboard');
        
        // Refleksi diri siswa
        Route::resource('refleksi', ReflectionController::class);

    });

    // =======================
    // 🔸 PROFIL (SEMUA ROLE)
    // =======================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// 🔹 DASHBOARD DEFAULT
// =======================
Route::get('/dashboard', fn() => redirect('/redirect'))
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/reports/{student}/export/pdf', [ReportController::class, 'exportPdf'])
    ->name('reports.export.pdf')
    ->middleware(['auth']);




// Auth scaffolding (Laravel Breeze)
require __DIR__.'/auth.php';
