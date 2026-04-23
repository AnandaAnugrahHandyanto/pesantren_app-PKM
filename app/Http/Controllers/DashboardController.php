<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSantri = Santri::count();

        $hadir = Absensi::whereDate('tanggal', today())->where('status', 'hadir')->count();
        $izin  = Absensi::whereDate('tanggal', today())->where('status', 'izin')->count();
        $alfa  = Absensi::whereDate('tanggal', today())->where('status', 'alfa')->count();

        return view('dashboard', compact('totalSantri', 'hadir', 'izin', 'alfa'));
    }
}
