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
        $guru = Auth::user()->guru;

        if (!$guru) {
            return view('guru.jadwal', [
                'grid' => [],
                'guru' => null,
                'hariList' => Jadwal::hariOptions(),
            ]);
        }

        // Filter by kelas if requested
        $kelas = $request->query('kelas');
        
        $kelasList = Jadwal::where('guru_id', $guru->id)
            ->select('kelas')
            ->distinct()
            ->pluck('kelas')
            ->sort();

        $query = Jadwal::with(['mataPelajaran', 'guru'])
            ->where('guru_id', $guru->id);
            
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

        return view('guru.jadwal', compact('grid', 'hariList', 'kelas', 'kelasList', 'guru'));
    }
}
