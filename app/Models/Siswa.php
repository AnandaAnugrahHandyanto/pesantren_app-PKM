<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'kelas',
        'jenis_kelamin',
    ];

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    /**
     * Auto-generate a unique NIS number.
     */
    public static function generateNIS(): string
    {
        $prefix = 'NIS-' . now()->format('Ymd');
        $attempts = 0;

        do {
            $suffix = str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);
            $nis = $prefix . '-' . $suffix;
            $attempts++;
        } while (self::where('nis', $nis)->exists() && $attempts < 10);

        return $nis;
    }
}
