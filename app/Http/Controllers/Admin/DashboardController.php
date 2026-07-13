<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa  = Siswa::count();
        $absensi      = $this->todayAbsensiCounts();
        $latestSiswa = Siswa::latest()->take(5)->get();

        return view('dashboard', array_merge(compact('totalSiswa', 'latestSiswa'), $absensi));
    }

    public function adminDashboard()
    {
        $totalSiswa     = Siswa::count();
        $siswaLaki      = Siswa::where('jenis_kelamin', 'L')->count();
        $siswaPerempuan = Siswa::where('jenis_kelamin', 'P')->count();
        $totalGuru       = User::where('role', 'guru')->count();
        $absensi         = $this->todayAbsensiCounts();
        $latestSiswa    = Siswa::latest()->take(5)->get();

        return view('admin.dashboard', array_merge(
            compact('totalSiswa', 'siswaLaki', 'siswaPerempuan', 'totalGuru', 'latestSiswa'),
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
            'sakit' => $counts->get('sakit', 0),
            'alfa'  => $counts->get('alfa', 0),
        ];
    }
}
