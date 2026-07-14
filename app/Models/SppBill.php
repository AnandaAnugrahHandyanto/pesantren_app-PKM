<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SppBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'bulan',
        'tahun',
        'jumlah',
        'status',
        'keuangan_id',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function keuangan(): BelongsTo
    {
        return $this->belongsTo(Keuangan::class, 'keuangan_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class, 'spp_bill_id');
    }

    /**
     * Nama bulan dalam Bahasa Indonesia.
     */
    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',   '09' => 'September',
            '10' => 'Oktober', '11' => 'November',  '12' => 'Desember',
        ];

        return $bulan[$this->bulan] ?? $this->bulan;
    }
}
