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
        $taList = \App\Helpers\TahunAkademik::listTahun();
        $taAktif = \App\Helpers\TahunAkademik::aktif();
        $taSelected = $request->ta ?? $taAktif['tahun'];
        $semesterSelected = $request->semester ?? '';

        $siswaQuery = Siswa::query();
        
        $siswaQuery->with(['sppBills' => function ($query) use ($taSelected, $semesterSelected) {
            $query->filterTa($taSelected, $semesterSelected);
        }]);

        if ($request->filled('status')) {
            $siswaQuery->whereHas('sppBills', function($q) use ($request, $taSelected, $semesterSelected) {
                $q->where('status', $request->status);
                $q->filterTa($taSelected, $semesterSelected);
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
        
        return view('spp.index', compact('taAktif', 'taSelected', 'taList', 'siswaList', 'kelasList', 'semesterSelected'));
}
    public function generate(Request $request)
    {
        $request->validate(['ta' => 'required|string', 'jumlah' => 'required|numeric|min:0']);
        $ta = $request->ta;
        $jumlah = $request->jumlah;
        
        $parts = explode('/', $ta);
        $tahunAwal = $parts[0];
        $tahunAkhir = $parts[1] ?? ($tahunAwal + 1);
        
        $siswaList = $request->filled('kelas') ? Siswa::where('kelas', $request->kelas)->get() : Siswa::all();
        $created = 0;
        
        foreach ($siswaList as $siswa) {
            // Ganjil
            for ($bulan = 7; $bulan <= 12; $bulan++) {
                $bulanStr = str_pad((string) $bulan, 2, '0', STR_PAD_LEFT);
                if (!SppBill::where('siswa_id', $siswa->id)->where('bulan', $bulanStr)->where('tahun', $tahunAwal)->exists()) {
                    SppBill::create(['siswa_id' => $siswa->id, 'bulan' => $bulanStr, 'tahun' => $tahunAwal, 'jumlah' => $jumlah, 'status' => 'belum']);
                    $created++;
                }
            }
            // Genap
            for ($bulan = 1; $bulan <= 6; $bulan++) {
                $bulanStr = str_pad((string) $bulan, 2, '0', STR_PAD_LEFT);
                if (!SppBill::where('siswa_id', $siswa->id)->where('bulan', $bulanStr)->where('tahun', $tahunAkhir)->exists()) {
                    SppBill::create(['siswa_id' => $siswa->id, 'bulan' => $bulanStr, 'tahun' => $tahunAkhir, 'jumlah' => $jumlah, 'status' => 'belum']);
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
        $taAktif = \App\Helpers\TahunAkademik::aktif();
        $taSelected = request('ta') ?? $taAktif['tahun'];
        
        $tagihanQuery = SppBill::where('siswa_id', $user->siswa_id);
        
        if (request('tab') === 'riwayat') {
            if (request('ta')) {
                $tagihanQuery->filterTa(request('ta'));
            }
        } else {
            $tagihanQuery->filterTa($taSelected);
        }
        
        $tagihan = $tagihanQuery->orderBy('tahun')
            ->orderBy('bulan')
            ->get();
            
        $taList = \App\Helpers\TahunAkademik::listTahun();
        $tab = request('tab', 'aktif');


        $totalTagihan = $tagihan->count();
        $totalLunas = $tagihan->where('status', 'lunas')->count();
        $totalBelum = $tagihan->where('status', 'belum')->count();
        $totalTunggakan = $tagihan->where('status', 'tunggakan')->count();
        $jumlahLunas = $tagihan->where('status', 'lunas')->sum('jumlah');
        $jumlahTotal = $tagihan->sum('jumlah');

        return view('siswa.spp', compact('taAktif', 'taSelected', 'taList', 'tab', 
            'tagihan', 'totalTagihan', 'totalLunas', 'totalBelum', 'totalTunggakan',
            'jumlahLunas', 'jumlahTotal'
        ));
    }
}
