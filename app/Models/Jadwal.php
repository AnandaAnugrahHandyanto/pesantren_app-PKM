<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $table = 'jadwals';

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'mata_pelajaran_id',
        'guru_id',
        'kelas',
        'rombel',
    ];

    protected function casts(): array
    {
        return [
            'jam_mulai' => 'datetime:H:i',
            'jam_selesai' => 'datetime:H:i',
        ];
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas', 'kelas');
    }

    /**
     * Daftar hari dalam Bahasa Indonesia.
     */
    public static function hariOptions(): array
    {
        return ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
    }
}
