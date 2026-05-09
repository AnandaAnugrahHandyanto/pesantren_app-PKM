<?php

namespace App\Imports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantriImport implements ToModel, WithHeadingRow
{
    public function model(array $row): ?Santri
    {
        $namaLengkap = isset($row['nama_lengkap']) ? trim((string) $row['nama_lengkap']) : null;

        if (empty($namaLengkap)) {
            return null;
        }

        $jenisKelaminRaw = isset($row['jenis_kelamin']) ? trim((string) $row['jenis_kelamin']) : '';
        $jenisKelaminMap = ['laki-laki' => 'L', 'perempuan' => 'P', 'l' => 'L', 'p' => 'P'];
        $jenisKelamin = $jenisKelaminMap[strtolower($jenisKelaminRaw)] ?? null;

        return new Santri([
            'nama_lengkap'  => $namaLengkap,
            'kelas'         => isset($row['kelas']) ? trim((string) $row['kelas']) : '',
            'jenis_kelamin' => $jenisKelamin,
        ]);
    }
}
