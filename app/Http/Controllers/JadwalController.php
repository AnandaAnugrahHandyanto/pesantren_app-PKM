<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Admin/Guru: daftar jadwal per kelas.
     */
    public function index(Request $request)
    {
        $rombelList = \App\Models\Siswa::select('rombel')->distinct()->pluck('rombel')->filter()->sort();
        $rombel = $request->rombel;

        $kelas = $request->kelas ?? '7A';
        $kelasList = \App\Models\MataPelajaran::select('kelas')->distinct()->pluck('kelas')->sort();

        $query = Jadwal::with(['mataPelajaran', 'guru']);
        
        if ($rombel) {
            $query->whereHas('siswa', function($q) use ($rombel) {
                $q->where('rombel', $rombel);
            });
        }
        
        $jadwals = $query->where('kelas', $kelas)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        // Group by day for grid view
        $grid = [];
        $jamList = collect();
        foreach (Jadwal::hariOptions() as $hari) {
            $grid[$hari] = $jadwals->where('hari', $hari)->values();
            $jamList = $jamList->merge($grid[$hari]->pluck('jam_mulai'))
                ->merge($grid[$hari]->pluck('jam_selesai'));
        }
        $jamList = $jamList->unique()->sort()->values();

        // Statistics
        $totalJadwal = $jadwals->count();
        $totalMapel = $jadwals->pluck('mata_pelajaran_id')->unique()->count();
        $totalGuru = $jadwals->pluck('guru_id')->filter()->unique()->count();

        return view('jadwal.index', compact('grid', 'kelas', 'kelasList', 'jamList',
            'totalJadwal', 'totalMapel', 'totalGuru', 'rombelList'));
    }

    /**
     * Admin: form tambah jadwal.
     */
    public function create()
    {
        $mapels = MataPelajaran::with('guru')->orderBy('nama')->get();
        $gurus = Guru::orderBy('nama_lengkap')->get();
        $kelasList = MataPelajaran::select('kelas')->distinct()->pluck('kelas')->sort();

        return view('jadwal.create', compact('mapels', 'gurus', 'kelasList'));
    }

    /**
     * Admin: simpan jadwal baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:' . implode(',', Jadwal::hariOptions()),
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'kelas' => 'required|string|max:10',
        ]);

        // Cek bentrok guru
        if ($request->filled('guru_id')) {
            $bentrok = Jadwal::where('hari', $request->hari)
                ->where('guru_id', $request->guru_id)
                ->where(function ($q) use ($request) {
                    $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q2) use ($request) {
                            $q2->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })->exists();

            if ($bentrok) {
                return back()->withErrors(['guru_id' => 'Guru sudah punya jadwal di jam ini.'])->withInput();
            }
        }

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index', ['kelas' => $request->kelas])
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Admin: form edit jadwal.
     */
    public function edit(Jadwal $jadwal)
    {
        $mapels = MataPelajaran::with('guru')->orderBy('nama')->get();
        $gurus = Guru::orderBy('nama_lengkap')->get();
        $kelasList = MataPelajaran::select('kelas')->distinct()->pluck('kelas')->sort();

        return view('jadwal.edit', compact('jadwal', 'mapels', 'gurus', 'kelasList'));
    }

    /**
     * Admin: update jadwal.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'hari' => 'required|in:' . implode(',', Jadwal::hariOptions()),
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'kelas' => 'required|string|max:10',
        ]);

        // Cek bentrok guru (kecuali dirinya sendiri)
        if ($request->filled('guru_id')) {
            $bentrok = Jadwal::where('hari', $request->hari)
                ->where('guru_id', $request->guru_id)
                ->where('id', '!=', $jadwal->id)
                ->where(function ($q) use ($request) {
                    $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q2) use ($request) {
                            $q2->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })->exists();

            if ($bentrok) {
                return back()->withErrors(['guru_id' => 'Guru sudah punya jadwal di jam ini.'])->withInput();
            }
        }

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index', ['kelas' => $request->kelas])
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Admin: hapus jadwal.
     */
    public function destroy(Jadwal $jadwal)
    {
        $kelas = $jadwal->kelas;
        $jadwal->delete();

        return redirect()->route('jadwal.index', ['kelas' => $kelas])
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Siswa: lihat jadwal sendiri berdasarkan kelas.
     */
    public function siswa()
    {
        $user = Auth::user();
        $kelasSiswa = $user->siswa->kelasFormatted ?? $user->siswa->kelas ?? '';

        $jadwals = Jadwal::with(['mataPelajaran', 'guru'])
            ->where('kelas', $kelasSiswa)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        $grid = [];
        foreach (Jadwal::hariOptions() as $hari) {
            $grid[$hari] = $jadwals->where('hari', $hari)->values();
        }

        return view('siswa.jadwal', compact('grid', 'kelasSiswa'));
    }
}
