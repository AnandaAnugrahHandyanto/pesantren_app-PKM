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
        $totalSiswa     = Siswa::count();
        $totalGuru      = User::where('role', 'guru')->count();
        $totalMapel     = \App\Models\MataPelajaran::count();

        // Mapping hari berdasarkan ISO day of week (1 = senin, 7 = minggu)
        $hariMap = [
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
            7 => 'minggu',
        ];
        $hariIni = $hariMap[now()->dayOfWeekIso] ?? 'senin';
        $totalJadwal = \App\Models\Jadwal::where('hari', $hariIni)->count();

        $absensi         = $this->todayAbsensiCounts();
        $latestSiswa    = Siswa::latest()->take(5)->get();

        // Ringkasan SPP: Tagihan tertunggak (status='tunggakan')
        $sppTunggakan   = \App\Models\SppBill::where('status', 'tunggakan')->count();
        $totalSppBills  = \App\Models\SppBill::count();

        return view('admin.dashboard', array_merge(
            compact('totalSiswa', 'totalGuru', 'totalMapel', 'totalJadwal', 'absensi', 'latestSiswa', 'sppTunggakan', 'totalSppBills'),
            $absensi
        ));
    }

    public function adminDashboard()
    {
        $totalSiswa     = Siswa::count();
        $totalGuru      = User::where('role', 'guru')->count();
        $totalMapel     = \App\Models\MataPelajaran::count();

        // Mapping hari berdasarkan ISO day of week (1 = senin, 7 = minggu)
        $hariMap = [
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
            7 => 'minggu',
        ];
        $hariIni = $hariMap[now()->dayOfWeekIso] ?? 'senin';
        $totalJadwal = \App\Models\Jadwal::where('hari', $hariIni)->count();

        $absensi         = $this->todayAbsensiCounts();
        $latestSiswa    = Siswa::latest()->take(5)->get();

        // Ringkasan SPP: Tagihan tertunggak (status='tunggakan')
        $sppTunggakan   = \App\Models\SppBill::where('status', 'tunggakan')->count();
        $totalSppBills  = \App\Models\SppBill::count();

        return view('admin.dashboard', array_merge(
            compact('totalSiswa', 'totalGuru', 'totalMapel', 'totalJadwal', 'absensi', 'latestSiswa', 'sppTunggakan', 'totalSppBills'),
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
