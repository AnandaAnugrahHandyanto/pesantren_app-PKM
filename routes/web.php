<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
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
        Route::get('/santri/import', [SiswaController::class, 'importForm'])->name('santri.import.form');
        Route::post('/santri/import', [SiswaController::class, 'importExcel'])->name('santri.import');
        Route::get('/santri/template', [SiswaController::class, 'downloadTemplate'])->name('santri.template');
        Route::resource('siswa', SiswaController::class);
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
