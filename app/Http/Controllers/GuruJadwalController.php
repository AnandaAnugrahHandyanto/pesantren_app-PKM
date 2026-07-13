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
        $guruId = $request->query('guru_id', $guru ? $guru->id : null);
        $kelas = $request->query('kelas');
        $rombel = $request->query('rombel');

        $guruList = Guru::orderBy('nama_lengkap')->get();
        $kelasList = Jadwal::select('kelas')->distinct()->pluck('kelas')->sort();
        $rombelList = Jadwal::select('rombel')->distinct()->pluck('rombel')->sort();

        $query = Jadwal::with(['mataPelajaran', 'guru']);

        if ($guruId) {
            $query->where('guru_id', $guruId);
        }
            
        if ($kelas) {
            $query->where('kelas', $kelas);
        }

        if ($rombel) {
            $query->where('rombel', $rombel);
        }

        $jadwals = $query->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        $grid = [];
        $hariList = Jadwal::hariOptions();
        foreach ($hariList as $hari) {
            $grid[$hari] = $jadwals->where('hari', $hari)->values();
        }

        return view('guru.jadwal', compact('grid', 'hariList', 'kelas', 'rombel', 'kelasList', 'rombelList', 'guruList', 'guruId'));
    }
}
