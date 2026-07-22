<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\SppBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SppController extends Controller
{
    private function getSummaryData($siswaId)
    {
        $siswa = Siswa::with('sppBills')->find($siswaId);
        \Log::info('getSummaryData', ['siswaId' => $siswaId, 'siswa' => $siswa ? $siswa->id : 'null']);
        if (!$siswa) return ['total' => 0, 'lunas' => 0, 'belum' => 0, 'tunggakan' => 0, 'sisa_tagihan' => 0, 'formatted_sisa_tagihan' => 'Rp 0'];

        $bills = $siswa->sppBills;
        return [
            'total' => $bills->count(),
            'lunas' => $bills->where('status', 'lunas')->count(),
            'belum' => $bills->where('status', 'belum')->count(),
            'tunggakan' => $bills->where('status', 'tunggakan')->count(),
            'sisa_tagihan' => (float)$bills->whereIn('status', ['belum', 'tunggakan'])->sum('jumlah'),
            'formatted_sisa_tagihan' => 'Rp ' . number_format($bills->whereIn('status', ['belum', 'tunggakan'])->sum('jumlah'), 0, ',', '.')
        ];
    }

    public function index(Request $request)
    {
        $siswaQuery = Siswa::query();
        $siswaQuery->with(['sppBills' => function ($query) use ($request) {
            if ($request->filled('tahun')) $query->where('tahun', $request->tahun);
            if ($request->filled('bulan')) $query->where('bulan', str_pad($request->bulan, 2, '0', STR_PAD_LEFT));
        }]);

        if ($request->filled('status')) {
            $siswaQuery->whereHas('sppBills', function($q) use ($request) {
                $q->where('status', $request->status);
                if ($request->filled('tahun')) $q->where('tahun', $request->tahun);
                if ($request->filled('bulan')) $q->where('bulan', str_pad($request->bulan, 2, '0', STR_PAD_LEFT));
            });
        }

        if ($request->filled('kelas')) $siswaQuery->where('kelas', $request->kelas);
        if ($request->filled('search')) {
            $search = $request->search;
            $siswaQuery->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $siswaList = $siswaQuery->orderBy('nama_lengkap')->paginate(20);
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas')->sort();
        return view('spp.index', compact('siswaList', 'kelasList'));
    }

    public function generate(Request $request)
    {
        $request->validate(['tahun' => 'required|integer|min:2020|max:2099', 'jumlah' => 'required|numeric|min:0']);
        $tahun = $request->tahun;
        $jumlah = $request->jumlah;
        $siswaList = $request->filled('kelas') ? Siswa::where('kelas', $request->kelas)->get() : Siswa::all();
        $created = 0;
        foreach ($siswaList as $siswa) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $bulanStr = str_pad((string) $bulan, 2, '0', STR_PAD_LEFT);
                if (!SppBill::where('siswa_id', $siswa->id)->where('bulan', $bulanStr)->where('tahun', $tahun)->exists()) {
                    SppBill::create(['siswa_id' => $siswa->id, 'bulan' => $bulanStr, 'tahun' => $tahun, 'jumlah' => $jumlah, 'status' => 'belum']);
                    $created++;
                }
            }
        }
        return redirect()->route('spp.index')->with('success', 'Berhasil generate ' . $created . ' tagihan baru.');
    }

    public function markPaid(SppBill $sppBill)
    {
        if ($sppBill->status === 'lunas') return response()->json(['success' => false, 'message' => 'Tagihan sudah lunas.'], 422);

        $keuangan = Keuangan::create([
            'tanggal' => now(), 'jenis' => 'pemasukan', 'kategori' => 'SPP',
            'keterangan' => 'Pembayaran SPP ' . $sppBill->nama_bulan . ' ' . $sppBill->tahun,
            'jumlah' => $sppBill->jumlah, 'siswa_id' => $sppBill->siswa_id,
        ]);
        $sppBill->update(['status' => 'lunas', 'keuangan_id' => $keuangan->id, 'paid_at' => now()]);
        return response()->json([
            'success' => true,
            'bill' => ['status' => 'lunas'],
            'summary' => $this->getSummaryData($sppBill->siswa_id)
        ]);
    }

    public function update(Request $request, SppBill $spp)
    {
        if ($spp->status === 'lunas' || $spp->keuangan_id !== null) return response()->json(['message' => 'Tagihan tidak dapat diubah.'], 422);

        $request->validate(['jumlah' => 'required|numeric|gt:0']);

        $spp->update(['jumlah' => $request->jumlah]);
        $spp = $spp->fresh();

        return response()->json([
            'success' => true,
            'bill' => [
                'id' => $spp->id,
                'jumlah' => (float) $spp->jumlah,
                'formatted_jumlah' => 'Rp ' . number_format($spp->jumlah, 0, ',', '.')
            ],
            'summary' => $this->getSummaryData($spp->siswa_id)
        ]);
    }

    public function destroy(SppBill $spp)
    {
        if ($spp->status === 'lunas' || $spp->keuangan_id !== null) return response()->json(['message' => 'Tagihan tidak dapat dihapus.'], 422);

        $siswaId = $spp->siswa_id;

        $deleted = $spp->delete();

        if (! $deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan gagal dihapus.',
            ], 500);
        }

        return response()->json(['success' => true, 'summary' => $this->getSummaryData($siswaId)]);
    }

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
