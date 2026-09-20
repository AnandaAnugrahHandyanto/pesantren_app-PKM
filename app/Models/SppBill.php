<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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

        $normalized = str_pad((string) $this->bulan, 2, '0', STR_PAD_LEFT);

        return $bulan[$normalized] ?? 'Bulan Tidak Valid';
    }
    /**
     * Dapatkan Tahun Akademik dari tagihan ini
     */
    public function getTahunAkademikAttribute()
    {
        $bulanInt = (int) $this->bulan;
        if ($bulanInt >= 7) {
            $tahunAwal = $this->tahun;
            $tahunAkhir = $tahunAwal + 1;
        } else {
            $tahunAkhir = $this->tahun;
            $tahunAwal = $tahunAkhir - 1;
        }
        return "{$tahunAwal}/{$tahunAkhir}";
    }

    /**
     * Dapatkan Semester dari tagihan ini
     */
    public function getSemesterAttribute()
    {
        $bulanInt = (int) $this->bulan;
        return ($bulanInt >= 7) ? 'Ganjil' : 'Genap';
    }

    /**
     * Scope filter Tahun Akademik dan Semester
     */
    public function scopeFilterTa($query, $ta = null, $semester = null)
    {
        if ($ta) {
            $parts = explode('/', $ta);
            if (count($parts) == 2) {
                $tahunAwal = $parts[0];
                $tahunAkhir = $parts[1];
                
                if ($semester == 'Ganjil') {
                    $query->where('tahun', $tahunAwal)->whereIn('bulan', ['07','08','09','10','11','12']);
                } elseif ($semester == 'Genap') {
                    $query->where('tahun', $tahunAkhir)->whereIn('bulan', ['01','02','03','04','05','06']);
                } else {
                    $query->where(function ($q) use ($tahunAwal, $tahunAkhir) {
                        $q->where(function ($q1) use ($tahunAwal) {
                            $q1->where('tahun', $tahunAwal)->whereIn('bulan', ['07','08','09','10','11','12']);
                        })->orWhere(function ($q2) use ($tahunAkhir) {
                            $q2->where('tahun', $tahunAkhir)->whereIn('bulan', ['01','02','03','04','05','06']);
                        });
                    });
                }
            }
        }
        return $query;
    }
}