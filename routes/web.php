<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\GuruJadwalController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::get('/beranda', [AdminDashboard::class, 'index'])->name('dashboard');
    });

    // Guru Routes
    Route::middleware(['role:guru'])->prefix('guru')->group(function () {
        Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('guru.dashboard');
        Route::get('/jadwal', [GuruJadwalController::class, 'index'])->name('guru.jadwal');
    });

    // Siswa Routes
    Route::middleware(['role:siswa'])->prefix('siswa')->group(function () {
        Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('siswa.dashboard');
        Route::get('/absensi', [SiswaDashboard::class, 'absensi'])->name('siswa.absensi');
        Route::get('/spp', [SiswaDashboard::class, 'sppIndex'])->name('siswa.spp.index');
        Route::get('/jadwal', [JadwalController::class, 'siswa'])->name('siswa.jadwal');
    });

    // Shared Routes (Absensi, etc.)
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('absensi', AbsensiController::class);
    Route::post('absensi/mass-store', [AbsensiController::class, 'massStore'])->name('absensi.mass-store');
    
    Route::get('rekap-absensi', [LaporanController::class, 'absensi'])->name('laporan.absensi');
    Route::get('rekap-absensi-semester', [LaporanController::class, 'rekapSemester'])->name('rekap.absensi.semester');
    Route::get('rekap-absensi-cetak', [LaporanController::class, 'rekapSemesterPrint'])->name('rekap.absensi.cetak');
    
    Route::resource('mata-pelajaran', MataPelajaranController::class);
    Route::resource('keuangan', KeuanganController::class);
    Route::resource('spp', SppController::class);
    Route::post('spp/{sppBill}/checkout', [PaymentController::class, 'checkout'])->name('spp.checkout');
    
    Route::resource('jadwal', JadwalController::class);
});

// Webhooks
Route::post('/payments/webhook', [WebhookController::class, 'handle']);

require __DIR__.'/auth.php';
