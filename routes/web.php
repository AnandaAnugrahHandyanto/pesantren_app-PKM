<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/siswa/import', [SiswaController::class, 'importForm'])->name('siswa.import.form');
        Route::post('/siswa/import', [SiswaController::class, 'importExcel'])->name('siswa.import');
        Route::get('/siswa/template', [SiswaController::class, 'downloadTemplate'])->name('siswa.template');
        Route::resource('siswa', SiswaController::class);
        Route::resource('guru', GuruController::class)->except(['show']);
        Route::resource('keuangan', KeuanganController::class)->except(['show']);
        Route::resource('mata-pelajaran', MataPelajaranController::class)->except(['show']);
    });

    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', [DashboardController::class, 'guruDashboard'])->name('guru.dashboard');
    });

    // Accessible to both admin and guru
    Route::post('/absensi/mass', [AbsensiController::class, 'massStore'])->name('absensi.mass-store');
    Route::resource('absensi', AbsensiController::class)->except(['show']);
    Route::get('/laporan/absensi', [LaporanController::class, 'absensi'])->name('laporan.absensi');
    Route::get('/rekap-absensi', [LaporanController::class, 'rekapSemester'])->name('rekap.absensi');
    Route::get('/rekap-absensi/cetak', [LaporanController::class, 'rekapSemesterPrint'])->name('rekap.absensi.cetak');
});

require __DIR__.'/auth.php';

// ─── Siswa Routes ─────────────────────────────────────────
Route::middleware(['auth', 'verified', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SiswaController::class, 'dashboard'])->name('dashboard');
});

// ─── SPP (Admin) ──────────────────────────────────────────
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('spp')->name('spp.')->group(function () {
    Route::get('/', [App\Http\Controllers\SppController::class, 'index'])->name('index');
    Route::get('/generate', [App\Http\Controllers\SppController::class, 'create'])->name('create');
    Route::post('/generate', [App\Http\Controllers\SppController::class, 'generate'])->name('generate');
    Route::post('/{sppBill}/paid', [App\Http\Controllers\SppController::class, 'markPaid'])->name('mark-paid');
});

// ─── Jadwal (Admin) ───────────────────────────────────────
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('jadwal')->name('jadwal.')->group(function () {
    Route::get('/', [App\Http\Controllers\JadwalController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\JadwalController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\JadwalController::class, 'store'])->name('store');
    Route::get('/{jadwal}/edit', [App\Http\Controllers\JadwalController::class, 'edit'])->name('edit');
    Route::put('/{jadwal}', [App\Http\Controllers\JadwalController::class, 'update'])->name('update');
    Route::delete('/{jadwal}', [App\Http\Controllers\JadwalController::class, 'destroy'])->name('destroy');
});

// ─── Siswa (akses siswa) ──────────────────────────────────
Route::middleware(['auth', 'verified', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/absensi', function () {
        $user = Auth::user();
        $absensis = App\Models\Absensi::where('siswa_id', $user->siswa_id)
            ->with('mataPelajaran')
            ->orderBy('tanggal', 'desc')
            ->paginate(30);
        return view('siswa.absensi', compact('absensis'));
    })->name('absensi');
    Route::get('/spp', [App\Http\Controllers\SppController::class, 'siswaIndex'])->name('spp.index');
    Route::get('/jadwal', [App\Http\Controllers\JadwalController::class, 'siswa'])->name('jadwal');
});
