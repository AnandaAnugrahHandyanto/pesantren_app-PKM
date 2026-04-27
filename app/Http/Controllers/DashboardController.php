<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSantri  = Santri::count();
        $absensi      = $this->todayAbsensiCounts();
        $latestSantri = Santri::latest()->take(5)->get();

        return view('dashboard', array_merge(compact('totalSantri', 'latestSantri'), $absensi));
    }

    public function adminDashboard()
    {
        $totalSantri     = Santri::count();
        $santriLaki      = Santri::where('jenis_kelamin', 'L')->count();
        $santriPerempuan = Santri::where('jenis_kelamin', 'P')->count();
        $totalGuru       = User::where('role', 'guru')->count();
        $absensi         = $this->todayAbsensiCounts();
        $latestSantri    = Santri::latest()->take(5)->get();

        return view('admin.dashboard', array_merge(
            compact('totalSantri', 'santriLaki', 'santriPerempuan', 'totalGuru', 'latestSantri'),
            $absensi
        ));
    }

    public function guruDashboard()
    {
        $absensi = $this->todayAbsensiCounts();

        return view('guru.dashboard', $absensi);
    }

    private function todayAbsensiCounts(): array
    {
        $counts = Absensi::whereDate('tanggal', today())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'hadir' => $counts->get('hadir', 0),
            'izin'  => $counts->get('izin', 0),
            'alfa'  => $counts->get('alfa', 0),
        ];
    }
}
