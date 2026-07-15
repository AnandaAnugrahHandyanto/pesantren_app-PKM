<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'nis' => $this->faker->unique()->numerify('NIS-########'),
            'nama_lengkap' => $this->faker->name,
            'kelas' => '7A',
            'tingkat' => 7,
            'rombel' => 'A',
            'jenis_kelamin' => 'L',
        ];
    }
}
