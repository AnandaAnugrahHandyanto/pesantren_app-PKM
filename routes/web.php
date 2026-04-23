<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SantriController;

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

    Route::middleware('role.admin')->group(function () {
        Route::resource('santri', SantriController::class);
    });

    Route::middleware('role.guru')->group(function () {
        Route::resource('absensi', AbsensiController::class)->except(['show']);
        Route::get('/laporan/absensi', [LaporanController::class, 'absensi'])->name('laporan.absensi');
    });
});

require __DIR__.'/auth.php';
