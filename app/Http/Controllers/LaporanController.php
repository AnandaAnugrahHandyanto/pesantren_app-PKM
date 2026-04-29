<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;
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

    public function rekapSemester(Request $request)
    {
        $currentYear  = (int) now()->format('Y');
        $currentMonth = (int) now()->format('m');

        $tahunAjaran = (int) $request->query('tahun_ajaran', $currentMonth >= 7 ? $currentYear : $currentYear - 1);
        $semester    = (int) $request->query('semester', $currentMonth >= 7 ? 1 : 2);

        // Semester 1: July–December of tahunAjaran
        // Semester 2: January–June of tahunAjaran + 1
        if ($semester === 1) {
            $from = "{$tahunAjaran}-07-01";
            $to   = "{$tahunAjaran}-12-31";
        } else {
            $yearSem2 = $tahunAjaran + 1;
            $from     = "{$yearSem2}-01-01";
            $to       = "{$yearSem2}-06-30";
        }

        $rekap = Santri::orderBy('kelas')->orderBy('nama')
            ->withCount([
                'absensis as hadir' => fn ($q) => $q->where('status', 'hadir')->whereBetween('tanggal', [$from, $to]),
                'absensis as izin'  => fn ($q) => $q->where('status', 'izin')->whereBetween('tanggal', [$from, $to]),
                'absensis as sakit' => fn ($q) => $q->where('status', 'sakit')->whereBetween('tanggal', [$from, $to]),
                'absensis as alfa'  => fn ($q) => $q->where('status', 'alfa')->whereBetween('tanggal', [$from, $to]),
            ])
            ->get();

        // Build a reasonable list of school years (last 5 years up to current)
        $startYear   = 2020;
        $tahunAjaranList = range($currentYear, $startYear, -1);

        return view('laporan.rekap-semester', compact(
            'rekap', 'semester', 'tahunAjaran', 'tahunAjaranList', 'from', 'to'
        ));
    }

    public function rekapSemesterPrint(Request $request)
    {
        $currentYear  = (int) now()->format('Y');
        $currentMonth = (int) now()->format('m');

        $tahunAjaran = (int) $request->query('tahun_ajaran', $currentMonth >= 7 ? $currentYear : $currentYear - 1);
        $semester    = (int) $request->query('semester', $currentMonth >= 7 ? 1 : 2);

        if ($semester === 1) {
            $from = "{$tahunAjaran}-07-01";
            $to   = "{$tahunAjaran}-12-31";
        } else {
            $yearSem2 = $tahunAjaran + 1;
            $from     = "{$yearSem2}-01-01";
            $to       = "{$yearSem2}-06-30";
        }

        $rekap = Santri::orderBy('kelas')->orderBy('nama')
            ->withCount([
                'absensis as hadir' => fn ($q) => $q->where('status', 'hadir')->whereBetween('tanggal', [$from, $to]),
                'absensis as izin'  => fn ($q) => $q->where('status', 'izin')->whereBetween('tanggal', [$from, $to]),
                'absensis as sakit' => fn ($q) => $q->where('status', 'sakit')->whereBetween('tanggal', [$from, $to]),
                'absensis as alfa'  => fn ($q) => $q->where('status', 'alfa')->whereBetween('tanggal', [$from, $to]),
            ])
            ->get();

        return view('laporan.rekap-semester-print', compact(
            'rekap', 'semester', 'tahunAjaran', 'from', 'to'
        ));
    }
}

