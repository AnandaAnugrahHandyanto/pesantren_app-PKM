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

        $nis = isset($row['nis']) ? trim((string) $row['nis']) : null;
        if (empty($nis)) {
            $nis = Siswa::generateNIS();
        } elseif (Siswa::where('nis', $nis)->exists()) {
            $nis = Siswa::generateNIS();
        }

        $jenisKelaminRaw = isset($row['jenis_kelamin']) ? trim((string) $row['jenis_kelamin']) : '';
        $jenisKelaminMap = ['laki-laki' => 'L', 'perempuan' => 'P', 'l' => 'L', 'p' => 'P'];
        $jenisKelamin = $jenisKelaminMap[strtolower($jenisKelaminRaw)] ?? null;

        // Support both old 'kelas' and new 'tingkat'/'jurusan' columns
        $tingkat = isset($row['tingkat']) ? (int) trim((string) $row['tingkat']) : null;
        $jurusan = isset($row['jurusan']) ? strtoupper(trim((string) $row['jurusan'])) : null;

        // If tingkat/jurusan not provided, try to parse from old 'kelas' field (e.g., "7A")
        if (!$tingkat || !$jurusan) {
            $kelasRaw = isset($row['kelas']) ? trim((string) $row['kelas']) : '';
            if (preg_match('/^(\d+)([A-Z])$/', $kelasRaw, $matches)) {
                $tingkat = $tingkat ?: (int) $matches[1];
                $jurusan = $jurusan ?: $matches[2];
            }
        }

        return new Siswa([
            'nis'           => $nis,
            'nama_lengkap'  => $namaLengkap,
            'kelas'         => $tingkat && $jurusan ? $tingkat . $jurusan : '',
            'tingkat'       => $tingkat,
            'jurusan'       => $jurusan,
            'jenis_kelamin' => $jenisKelamin,
        ]);
    }
}