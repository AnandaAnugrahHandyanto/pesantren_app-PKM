<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajarans';

    protected $fillable = [
        'nama',
        'kelas',
        'kelas_v2',
        'rombel',
        'guru_id',
    ];
    
    protected $casts = [
        'kelas_v2' => 'integer',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'mata_pelajaran_id');
    }
}
