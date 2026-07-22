<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use App\Services\SiswaService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class SiswaImport implements ToModel, WithHeadingRow
{
    private ?string $defaultPassword;

    public function __construct(?string $defaultPassword = null)
    {
        $this->defaultPassword = $defaultPassword;
    }

    public function model(array $row): ?Siswa
    {
        // Validation ensures required fields are present to prevent NULL in DB
        $validator = Validator::make($row, [
            'nama_lengkap' => 'required',
            'tingkat'      => 'required|integer',
            'rombel'       => 'required',
        ]);

        if ($validator->fails()) {
            return null;
        }

        $namaLengkap = trim((string) $row['nama_lengkap']);
        $tingkat = (int) trim((string) $row['tingkat']);
        $rombel = strtoupper(trim((string) $row['rombel']));
        
        $nis = isset($row['nis']) ? trim((string) $row['nis']) : null;
        if (empty($nis) || Siswa::where('nis', $nis)->exists()) {
            $nis = Siswa::generateNIS();
        }

        $jenisKelaminRaw = isset($row['jenis_kelamin']) ? trim((string) $row['jenis_kelamin']) : '';
        $jenisKelaminMap = ['laki-laki' => 'L', 'perempuan' => 'P', 'l' => 'L', 'p' => 'P'];
        $jenisKelamin = $jenisKelaminMap[strtolower($jenisKelaminRaw)] ?? 'L';

        $siswa = Siswa::create([
            'nis'           => $nis,
            'nama_lengkap'  => $namaLengkap,
            'kelas_v2'      => $tingkat,
            'rombel'        => $rombel,
            'kelas'         => $tingkat . $rombel,
            'tingkat'       => $tingkat,
            'jenis_kelamin' => $jenisKelamin,
        ]);

        $password = !empty($this->defaultPassword) ? $this->defaultPassword : 'siswa123';
        SiswaService::createUserForSiswa($siswa, $password);

        return $siswa;
    }
}
