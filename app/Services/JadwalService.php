<?php

namespace App\Services;

use App\Models\Jadwal;
use Illuminate\Support\Collection;

class JadwalService
{
    public function getJadwalByKelasRombel(?string $kelas, ?string $rombel): Collection
    {
        if (empty($kelas) || empty($rombel)) {
            return collect();
        }

        return Jadwal::with(['mataPelajaran', 'guru'])
            ->where('kelas', $kelas)
            ->where('rombel', $rombel)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
    }
}
