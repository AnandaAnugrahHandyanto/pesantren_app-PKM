<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\SppBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SppController extends Controller
{
    /**
     * Admin: daftar semua tagihan SPP.
     */
    public function index(Request $request)
    {
        $query = SppBill::with('siswa')->orderBy('tahun', 'desc')->orderBy('bulan');

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas', $request->kelas));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $tagihan = $query->paginate(50);
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas')->sort();

        // Statistics
        $totalTagihan = $tagihan->total();
        $totalLunas = SppBill::where('status', 'lunas')->count();
        $totalTunggakan = SppBill::where('status', 'tunggakan')->count();
        $totalBelum = SppBill::where('status', 'belum')->count();
        $totalJumlah = SppBill::sum('jumlah');
        $jumlahLunas = SppBill::where('status', 'lunas')->sum('jumlah');

        return view('spp.index', compact(
            'tagihan', 'kelasList',
            'totalTagihan', 'totalLunas', 'totalTunggakan', 'totalBelum',
            'totalJumlah', 'jumlahLunas'
        ));
    }

    /**
     * Admin: form generate tagihan massal.
     */
    public function create()
    {
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas')->sort();
        return view('spp.create', compact('kelasList'));
    }

    /**
     * Admin: generate tagihan SPP untuk semua siswa (per tahun).
     */
    public function generate(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2020|max:2099',
            'jumlah' => 'required|numeric|min:0',
            'kelas' => 'nullable|string',
        ]);

        $tahun = $request->tahun;
        $jumlah = $request->jumlah;

        $siswaQuery = Siswa::query();
        if ($request->filled('kelas')) {
            $siswaQuery->where('kelas', $request->kelas);
        }
        $siswaList = $siswaQuery->get();

        $created = 0;
        $skipped = 0;

        foreach ($siswaList as $siswa) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $bulanStr = str_pad((string) $bulan, 2, '0', STR_PAD_LEFT);

                $exists = SppBill::where('siswa_id', $siswa->id)
                    ->where('bulan', $bulanStr)
                    ->where('tahun', $tahun)
                    ->exists();

                if (! $exists) {
                    SppBill::create([
                        'siswa_id' => $siswa->id,
                        'bulan' => $bulanStr,
                        'tahun' => $tahun,
                        'jumlah' => $jumlah,
                        'status' => 'belum',
                    ]);
                    $created++;
                } else {
                    $skipped++;
                }
            }
        }

        return redirect()->route('spp.index')
            ->with('success', 'Berhasil generate ' . $created . ' tagihan baru. ' . $skipped . ' sudah ada.');
    }

    /**
     * Admin: tandai SPP lunas (manual).
     */
    public function markPaid(SppBill $sppBill)
    {
        if ($sppBill->status === 'lunas') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        // Catat ke tabel keuangan
        $keuangan = Keuangan::create([
            'tanggal' => now(),
            'jenis' => 'pemasukan',
            'kategori' => 'SPP',
            'keterangan' => 'Pembayaran SPP ' . $sppBill->nama_bulan . ' ' . $sppBill->tahun
                . ' — ' . ($sppBill->siswa->nama_lengkap ?? ''),
            'jumlah' => $sppBill->jumlah,
            'siswa_id' => $sppBill->siswa_id,
        ]);

        $sppBill->update([
            'status' => 'lunas',
            'keuangan_id' => $keuangan->id,
            'paid_at' => now(),
        ]);

        return back()->with('success', 'SPP ' . $sppBill->nama_bulan . ' ' . $sppBill->tahun . ' ditandai lunas.');
    }

    // ─── Siswa ──────────────────────────────────────────────

    /**
     * Siswa: lihat tagihan SPP sendiri.
     */
    public function siswaIndex()
    {
        $user = Auth::user();
        $tagihan = SppBill::where('siswa_id', $user->siswa_id)
            ->where('tahun', now()->year)
            ->orderBy('bulan')
            ->get();

        $totalTagihan = $tagihan->count();
        $totalLunas = $tagihan->where('status', 'lunas')->count();
        $totalBelum = $tagihan->where('status', 'belum')->count();
        $totalTunggakan = $tagihan->where('status', 'tunggakan')->count();
        $jumlahLunas = $tagihan->where('status', 'lunas')->sum('jumlah');
        $jumlahTotal = $tagihan->sum('jumlah');

        return view('siswa.spp', compact(
            'tagihan', 'totalTagihan', 'totalLunas', 'totalBelum', 'totalTunggakan',
            'jumlahLunas', 'jumlahTotal'
        ));
    }
}
