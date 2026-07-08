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
    ->name('dashboard')
    ->title('Dashboard | ' . config('app.name', 'Laravel'));

Route::get('404', function () {
    return view('_404');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
            ->name('admin.dashboard')
            ->title('Dashboard Admin | ' . config('app.name'));
        Route::get('/siswa/import', [SiswaController::class, 'importForm'])
            ->name('siswa.import.form')
            ->title('Import Siswa | ' . config('app.name'));
        Route::post('/siswa/import', [SiswaController::class, 'importExcel'])
            ->name('siswa.import');
        Route::get('/siswa/template', [SiswaController::class, 'downloadTemplate'])
            ->name('siswa.template');
        Route::resource('siswa', SiswaController::class);
        Route::resource('guru', GuruController::class)->except(['show']);
        Route::resource('keuangan', KeuanganController::class)->except(['show']);
        Route::resource('mata-pelajaran', MataPelajaranController::class)->except(['show']);
    });

    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', [DashboardController::class, 'guruDashboard'])
            ->name('guru.dashboard')
            ->title('Dashboard Guru | ' . config('app.name'));
    });

    Route::post('/absensi/mass', [AbsensiController::class, 'massStore'])->name('absensi.mass-store');
    Route::resource('absensi', AbsensiController::class)->except(['show']);
    Route::get('/laporan/absensi', [LaporanController::class, 'absensi'])
        ->name('laporan.absensi')
        ->title('Laporan Absensi | ' . config('app.name'));
    Route::get('/rekap-absensi', [LaporanController::class, 'rekapSemester'])
        ->name('rekap.absensi')
        ->title('Rekap Absensi | ' . config('app.name'));
    Route::get('/rekap-absensi/cetak', [LaporanController::class, 'rekapSemesterPrint'])
        ->name('rekap.absensi.cetak')
        ->title('Cetak Rekap Absensi | ' . config('app.name'));
});

require __DIR__.'/auth.php';
