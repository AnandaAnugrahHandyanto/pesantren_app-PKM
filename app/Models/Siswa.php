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
        'tingkat',
        'jurusan',
        'jenis_kelamin',
    ];

    protected $casts = [
        'tingkat' => 'integer',
    ];

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    /**
     * Get the formatted kelas (e.g., "7A", "8B").
     */
    public function getKelasFormattedAttribute(): string
    {
        return $this->tingkat . $this->jurusan;
    }

    /**
     * Get list of available tingkat options.
     */
    public static function tingkatOptions(): array
    {
        return [7, 8, 9];
    }

    /**
     * Get list of available jurusan options.
     */
    public static function jurusanOptions(): array
    {
        return ['A', 'B', 'C', 'D', 'E'];
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