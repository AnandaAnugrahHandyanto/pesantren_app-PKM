<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nama_lengkap',
        'kelas',
        'jenis_kelamin',
    ];

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}
