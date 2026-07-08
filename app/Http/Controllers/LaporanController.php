<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function absensi(Request $request)
    {
        $tanggal  = $request->query('tanggal', today()->toDateString());
        $mataPelajaranId = $request->query('mata_pelajaran_id');

        $mataPelajaranOptions = MataPelajaran::orderBy('kelas')->orderBy('nama')->get();

        $absensis = Absensi::with('siswa', 'mataPelajaran')
            ->whereDate('tanggal', $tanggal)
            ->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId))
            ->orderBy('id')
            ->get();

        $ringkasan = [
            'hadir' => $absensis->where('status', 'hadir')->count(),
            'izin'  => $absensis->where('status', 'izin')->count(),
            'sakit' => $absensis->where('status', 'sakit')->count(),
            'alfa'  => $absensis->where('status', 'alfa')->count(),
        ];

        return view('laporan.absensi', compact('absensis', 'tanggal', 'ringkasan', 'mataPelajaranOptions', 'mataPelajaranId'));
    }

    public function rekapSemester(Request $request)
    {
        $currentYear  = (int) now()->format('Y');
        $currentMonth = (int) now()->format('m');

        $tahunAjaran = (int) $request->query('tahun_ajaran', $currentMonth >= 7 ? $currentYear : $currentYear - 1);
        $semester    = (int) $request->query('semester', $currentMonth >= 7 ? 1 : 2);
        $mataPelajaranId = $request->query('mata_pelajaran_id');

        // Semester Ganjil: July–December of tahunAjaran
        // Semester Genap: January–June of tahunAjaran + 1
        if ($semester === 1) {
            $from = "{$tahunAjaran}-07-01";
            $to   = "{$tahunAjaran}-12-31";
            $semesterLabel = 'Ganjil';
        } else {
            $yearSem2 = $tahunAjaran + 1;
            $from     = "{$yearSem2}-01-01";
            $to       = "{$yearSem2}-06-30";
            $semesterLabel = 'Genap';
        }

        $mataPelajaranOptions = MataPelajaran::orderBy('kelas')->orderBy('nama')->get();

        $rekap = Siswa::orderBy('kelas')->orderBy('nama_lengkap')
            ->withCount([
                'absensis as hadir' => fn ($q) => $q->where('status', 'hadir')->whereBetween('tanggal', [$from, $to])->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId)),
                'absensis as izin'  => fn ($q) => $q->where('status', 'izin')->whereBetween('tanggal', [$from, $to])->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId)),
                'absensis as sakit' => fn ($q) => $q->where('status', 'sakit')->whereBetween('tanggal', [$from, $to])->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId)),
                'absensis as alfa'  => fn ($q) => $q->where('status', 'alfa')->whereBetween('tanggal', [$from, $to])->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId)),
            ])
            ->get();

        // Build a reasonable list of school years (last 5 years up to current)
        $startYear       = 2020;
        $tahunAjaranList = range($currentYear, $startYear, -1);

        return view('laporan.rekap-semester', compact(
            'rekap', 'semester', 'semesterLabel', 'tahunAjaran', 'tahunAjaranList', 'from', 'to', 'mataPelajaranOptions', 'mataPelajaranId'
        ));
    }

    public function rekapSemesterPrint(Request $request)
    {
        $currentYear  = (int) now()->format('Y');
        $currentMonth = (int) now()->format('m');

        $tahunAjaran = (int) $request->query('tahun_ajaran', $currentMonth >= 7 ? $currentYear : $currentYear - 1);
        $semester    = (int) $request->query('semester', $currentMonth >= 7 ? 1 : 2);
        $mataPelajaranId = $request->query('mata_pelajaran_id');

        if ($semester === 1) {
            $from = "{$tahunAjaran}-07-01";
            $to   = "{$tahunAjaran}-12-31";
            $semesterLabel = 'Ganjil';
        } else {
            $yearSem2 = $tahunAjaran + 1;
            $from     = "{$yearSem2}-01-01";
            $to       = "{$yearSem2}-06-30";
            $semesterLabel = 'Genap';
        }

        $mataPelajaranOptions = MataPelajaran::orderBy('kelas')->orderBy('nama')->get();

        $rekap = Siswa::orderBy('kelas')->orderBy('nama_lengkap')
            ->withCount([
                'absensis as hadir' => fn ($q) => $q->where('status', 'hadir')->whereBetween('tanggal', [$from, $to])->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId)),
                'absensis as izin'  => fn ($q) => $q->where('status', 'izin')->whereBetween('tanggal', [$from, $to])->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId)),
                'absensis as sakit' => fn ($q) => $q->where('status', 'sakit')->whereBetween('tanggal', [$from, $to])->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId)),
                'absensis as alfa'  => fn ($q) => $q->where('status', 'alfa')->whereBetween('tanggal', [$from, $to])->when($mataPelajaranId, fn ($q) => $q->where('mata_pelajaran_id', $mataPelajaranId)),
            ])
            ->get();

        return view('laporan.rekap-semester-print', compact(
            'rekap', 'semester', 'semesterLabel', 'tahunAjaran', 'from', 'to', 'mataPelajaranOptions', 'mataPelajaranId'
        ));
    }
}
