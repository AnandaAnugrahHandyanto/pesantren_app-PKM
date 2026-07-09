<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    private int $success = 0;
    private int $skipped = 0;

    public function getResults(): array
    {
        return [
            'success' => $this->success,
            'skipped' => $this->skipped,
        ];
    }

    public function model(array $row): ?Siswa
    {
        $namaLengkap = isset($row['nama_lengkap']) ? trim((string) $row['nama_lengkap']) : null;

        if (empty($namaLengkap)) {
            $this->skipped++;
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

        // Support both old 'kelas' and new 'tingkat'/'rombel' columns
                $tingkat = isset($row['tingkat']) ? (int) trim((string) $row['tingkat']) : null;
                $rombel = isset($row['rombel']) ? strtoupper(trim((string) $row['rombel'])) : null;
                // Fallback: also check 'jurusan' column for backward compat
                if (!$rombel && isset($row['jurusan'])) {
                    $rombel = strtoupper(trim((string) $row['jurusan']));
                }

                // If tingkat/rombel not provided, try to parse from old 'kelas' field (e.g., "7A")
                if (!$tingkat || !$rombel) {
                    $kelasRaw = isset($row['kelas']) ? trim((string) $row['kelas']) : '';
                    if (preg_match('/^(\\d+)([A-Z])$/', $kelasRaw, $matches)) {
                        $tingkat = $tingkat ?: (int) $matches[1];
                        $rombel = $rombel ?: $matches[2];
                    }
                }

                $this->success++;

                return new Siswa([
                    'nis'           => $nis,
                    'nama_lengkap'  => $namaLengkap,
                    'kelas'         => $tingkat && $rombel ? $tingkat . $rombel : '',
                    'tingkat'       => $tingkat,
                    'rombel'        => $rombel,
                    'jenis_kelamin' => $jenisKelamin,
                ]);
    }
}