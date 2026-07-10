<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $guruId = $this->route('guru')?->id;

        return [
            'nama_lengkap'   => ['required', 'string', 'max:255'],
            'username'       => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->user()?->id)],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()?->id)],
            'password'       => ['nullable', 'string', 'min:8', 'confirmed'],
            'nip'            => ['nullable', 'string', 'max:255', Rule::unique('gurus', 'nip')->ignore($guruId)],
            'no_hp'          => ['nullable', 'string', 'max:20'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'alamat'         => ['nullable', 'string'],
            'tanggal_lahir'  => ['nullable', 'date'],
            'tanggal_masuk'  => ['nullable', 'date'],
            'foto'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}
