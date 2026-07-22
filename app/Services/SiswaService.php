<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaService
{
    public static function createUserForSiswa(Siswa $siswa, string $password): User
    {
        $nis = $siswa->nis ?? 'NIS-' . str_pad((string) $siswa->id, 6, '0', STR_PAD_LEFT);

        return User::create([
            'name' => $siswa->nama_lengkap,
            'nis' => $nis,
            'email' => null,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'role' => 'siswa',
            'siswa_id' => $siswa->id,
        ]);
    }
}
