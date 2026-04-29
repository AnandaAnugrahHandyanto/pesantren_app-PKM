<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SantriController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/santri/import', [SantriController::class, 'importForm'])->name('santri.import.form');
        Route::post('/santri/import', [SantriController::class, 'importExcel'])->name('santri.import');
        Route::resource('santri', SantriController::class);
    });

    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', [DashboardController::class, 'guruDashboard'])->name('guru.dashboard');
    });

    // Accessible to both admin and guru
    Route::resource('absensi', AbsensiController::class)->except(['show']);
    Route::get('/laporan/absensi', [LaporanController::class, 'absensi'])->name('laporan.absensi');
});

require __DIR__.'/auth.php';
