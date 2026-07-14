<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\SppBill;
use Illuminate\Database\Eloquent\Factories\Factory;

class SppBillFactory extends Factory
{
    protected $model = SppBill::class;

    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'bulan' => '01',
            'tahun' => now()->year,
            'jumlah' => 50000,
            'status' => 'belum',
        ];
    }
}
