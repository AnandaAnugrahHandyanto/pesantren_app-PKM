<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruJadwalController extends Controller
{
    public function index(Request $request)
    {
        $currentGuru = Auth::user()->guru;
        $guruId = $request->query('guru_id', $currentGuru ? $currentGuru->id : null);
        $kelas = $request->query('kelas');

        $guru = $guruId ? Guru::find($guruId) : $currentGuru;

        // Fetch options
        $guruList = Guru::orderBy('nama_lengkap')->get();
        $kelasList = Jadwal::query()
            ->when($guruId, fn ($q) => $q->where('guru_id', $guruId))
            ->select('kelas')
            ->distinct()
            ->pluck('kelas')
            ->sort();

        $query = Jadwal::with(['mataPelajaran', 'guru']);

        if ($guruId) {
            $query->where('guru_id', $guruId);
        }
            
        if ($kelas) {
            $query->where('kelas', $kelas);
        }

        $jadwals = $query->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        $grid = [];
        $hariList = Jadwal::hariOptions();
        foreach ($hariList as $hari) {
            $grid[$hari] = $jadwals->where('hari', $hari)->values();
        }

        return view('guru.jadwal', compact('grid', 'hariList', 'kelas', 'kelasList', 'guru', 'guruList', 'guruId'));
    }
}
