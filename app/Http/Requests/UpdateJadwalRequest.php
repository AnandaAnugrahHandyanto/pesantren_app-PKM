<?php

namespace App\Http\Requests;

use App\Models\Jadwal;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hari' => 'required|in:' . implode(',', Jadwal::hariOptions()),
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'kelas' => 'required|string|max:10',
        ];
    }
}