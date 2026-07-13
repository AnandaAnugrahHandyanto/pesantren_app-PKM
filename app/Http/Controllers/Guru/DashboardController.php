<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today()->toDateString();
        
        $stats = Absensi::whereDate('tanggal', $today)
            ->selectRaw("
                count(case when status = 'hadir' then 1 end) as hadir,
                count(case when status = 'izin' then 1 end) as izin,
                count(case when status = 'sakit' then 1 end) as sakit,
                count(case when status = 'alfa' then 1 end) as alfa
            ")
            ->first();

        return view('guru.dashboard', [
            'hadir' => $stats->hadir ?? 0,
            'izin' => $stats->izin ?? 0,
            'sakit' => $stats->sakit ?? 0,
            'alfa' => $stats->alfa ?? 0,
        ]);
    }
}
