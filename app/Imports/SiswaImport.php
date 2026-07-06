<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row): ?Siswa
    {
        $namaLengkap = isset($row['nama_lengkap']) ? trim((string) $row['nama_lengkap']) : null;

        if (empty($namaLengkap)) {
            return null;
        }

        $jenisKelaminRaw = isset($row['jenis_kelamin']) ? trim((string) $row['jenis_kelamin']) : '';
        $jenisKelaminMap = ['laki-laki' => 'L', 'perempuan' => 'P', 'l' => 'L', 'p' => 'P'];
        $jenisKelamin = $jenisKelaminMap[strtolower($jenisKelaminRaw)] ?? null;

        return new Siswa([
            'nama_lengkap'  => $namaLengkap,
            'kelas'         => isset($row['kelas']) ? trim((string) $row['kelas']) : '',
            'jenis_kelamin' => $jenisKelamin,
        ]);
    }
}
