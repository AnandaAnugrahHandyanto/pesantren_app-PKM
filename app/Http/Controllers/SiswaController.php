<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Siswa dashboard — menampilkan absensi milik siswa yang login.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil data absensi untuk siswa ini
        $absensis = Absensi::where('siswa_id', $user->siswa_id)
            ->with('mataPelajaran')
            ->orderBy('tanggal', 'desc')
            ->limit(30)
            ->get();

        $stats = [
            'total' => $absensis->count(),
            'hadir' => $absensis->where('status', 'hadir')->count(),
            'izin'  => $absensis->where('status', 'izin')->count(),
            'sakit' => $absensis->where('status', 'sakit')->count(),
            'alfa'  => $absensis->where('status', 'alfa')->count(),
        ];

        // Ambil data SPP tagihan
        $tagihan = \App\Models\SppBill::where('siswa_id', $user->siswa_id)
            ->where('tahun', now()->year)
            ->orderBy('bulan')
            ->get();

        $statSpp = [
            'lunas' => $tagihan->where('status', 'lunas')->count(),
            'total' => $tagihan->count(),
        ];

        return view('siswa.dashboard', compact('absensis', 'stats', 'tagihan', 'statSpp'));
    }
}
