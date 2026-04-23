<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function absensi(Request $request)
    {
        $tanggal = $request->query('tanggal', today()->toDateString());

        $absensis = Absensi::with('santri')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('id')
            ->get();

        $ringkasan = [
            'hadir' => $absensis->where('status', 'hadir')->count(),
            'izin'  => $absensis->where('status', 'izin')->count(),
            'alfa'  => $absensis->where('status', 'alfa')->count(),
        ];

        return view('laporan.absensi', compact('absensis', 'tanggal', 'ringkasan'));
    }
}
