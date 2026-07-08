<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::query()->with('siswa');

        // Filter by month/year
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Filter by type
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $keuangans = $query->latest('tanggal')->paginate(25);

        // Summary
        $totalPemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $bulanOptions = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('keuangan.index', compact(
            'keuangans', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'bulanOptions'
        ));
    }

    public function create()
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();
        return view('keuangan.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis' => ['required', Rule::in(['pemasukan', 'pengeluaran'])],
            'kategori' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'jumlah' => ['required', 'numeric', 'min:0'],
            'siswa_id' => ['nullable', 'integer', 'exists:siswas,id'],
        ]);

        Keuangan::create($validated);

        return redirect()->route('keuangan.index')
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    public function edit(Keuangan $keuangan)
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();
        return view('keuangan.edit', compact('keuangan', 'siswas'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis' => ['required', Rule::in(['pemasukan', 'pengeluaran'])],
            'kategori' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'jumlah' => ['required', 'numeric', 'min:0'],
            'siswa_id' => ['nullable', 'integer', 'exists:siswas,id'],
        ]);

        $keuangan->update($validated);

        return redirect()->route('keuangan.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();

        return redirect()->route('keuangan.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}