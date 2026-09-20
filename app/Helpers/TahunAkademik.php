<?php

namespace App\Helpers;

use Carbon\Carbon;

class TahunAkademik
{
    public static function listTahun($startYear = 2023, $endYear = null)
    {
        $currentYear = date('Y');
        $endYear = $endYear ?? ($currentYear + 2);
        $list = [];

        for ($y = $startYear; $y <= $endYear; $y++) {
            $next = $y + 1;
            $list[] = "{$y}/{$next}";
        }

        return array_reverse($list);
    }

    public static function aktif()
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        if ($month >= 7) {
            $tahunAwal = $year;
            $semester = 'Ganjil';
        } else {
            $tahunAwal = $year - 1;
            $semester = 'Genap';
        }

        $next = $tahunAwal + 1;

        return [
            'tahun' => "{$tahunAwal}/{$next}",
            'semester' => $semester,
            'tahun_awal' => $tahunAwal,
        ];
    }
}
