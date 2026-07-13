<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap'   => ['required', 'string', 'max:255'],
            'username'       => ['required', 'string', 'max:255', 'unique:users,username'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
            'nip'            => ['nullable', 'string', 'max:255', 'unique:gurus,nip'],
            'no_hp'          => ['nullable', 'string', 'max:20'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'alamat'         => ['nullable', 'string'],
            'tanggal_lahir'  => ['nullable', 'date'],
            'tanggal_masuk'  => ['nullable', 'date'],
            'foto'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}
