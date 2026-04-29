<?php

namespace App\Imports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantriImport implements ToModel, WithHeadingRow
{
    public function model(array $row): ?Santri
    {
        $nama = isset($row['nama']) ? trim((string) $row['nama']) : null;

        if (empty($nama)) {
            return null;
        }

        return new Santri([
            'nama'  => $nama,
            'kelas' => isset($row['kelas']) ? trim((string) $row['kelas']) : '',
        ]);
    }
}
