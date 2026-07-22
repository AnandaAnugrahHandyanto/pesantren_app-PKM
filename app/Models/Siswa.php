<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'kelas',
        'kelas_v2',
        'rombel',
        'tingkat',
        'jenis_kelamin',
    ];

    protected $casts = [
        'tingkat' => 'integer',
        'kelas_v2' => 'integer',
    ];

    public function sppBills()
    {
        return $this->hasMany(SppBill::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'siswa_id');
    }

    /**
     * Get the formatted kelas (e.g., "7A", "8B").
     */
    public function getKelasFormattedAttribute(): string
    {
        return $this->tingkat.$this->rombel;
    }

    /**
     * Get the formatted kelas-rombel (e.g., "7-A", "8-B").
     */
    public function getKelasRombelAttribute(): string
    {
        if ($this->kelas_v2 && $this->rombel) {
            return "{$this->kelas_v2}-{$this->rombel}";
        }
        return $this->kelas;
    }

    /**
     * Get list of available tingkat options.
     */
    public static function tingkatOptions(): array
    {
        return [7, 8, 9];
    }

    /**
     * Get list available rombel options.
     */
    public static function rombelOptions(): array
    {
        return ['A', 'B', 'C', 'D', 'E'];
    }

    /**
     * Auto-generate a unique NIS number.
     */
    public static function generateNIS(): string
    {
        $prefix = 'NIS-'.now()->format('Ymd');
        $attempts = 0;

        do {
            $suffix = str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);
            $nis = $prefix.'-'.$suffix;
            $attempts++;
        } while (self::where('nis', $nis)->exists() && $attempts < 10);

        return $nis;
    }
}
