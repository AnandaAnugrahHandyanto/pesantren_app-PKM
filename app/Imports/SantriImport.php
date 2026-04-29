<?php

namespace App\Imports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantriImport implements ToModel, WithHeadingRow
{
    public function model(array $row): ?Santri
    {
        $nis = isset($row['nis']) ? trim((string) $row['nis']) : null;

        if (empty($nis) || Santri::where('nis', $nis)->exists()) {
            return null;
        }

        return new Santri([
            'nis'   => $nis,
            'nama'  => isset($row['nama']) ? trim((string) $row['nama']) : '',
            'kelas' => isset($row['kelas']) ? trim((string) $row['kelas']) : '',
            'kamar' => isset($row['alamat']) ? trim((string) $row['alamat']) : '', // 'alamat' in Excel maps to 'kamar' (room/location) in the database
        ]);
    }
}
