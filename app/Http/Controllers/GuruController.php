<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('user')->latest()->paginate(15);

        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(StoreGuruRequest $request)
    {
        $validated = $request->validated();
        $password  = $validated['password'];

        // Remove password from guru data (gurus table doesn't have password)
        unset($validated['password'], $validated['username']);

        if (empty($validated['nip'])) {
            $validated['nip'] = null;
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru = Guru::create($validated);

        // Create User account for login
        User::create([
            'name'       => $guru->nama_lengkap,
            'username'   => $request->username,
            'email'      => $guru->email,
            'password'   => Hash::make($password),
            'role'       => 'guru',
            'guru_id'    => $guru->id,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru dan akun login berhasil dibuat.');
    }

    public function edit(Guru $guru)
    {
        $guru->load('user');

        return view('guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru)
    {
        $validated = $request->validated();
        $password  = $validated['password'] ?? null;

        // Remove password from guru data
        unset($validated['password'], $validated['username']);

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $validated['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($validated);

        // Update linked User account
        $user = $guru->user;
        if ($user) {
            $user->update([
                'name'     => $guru->nama_lengkap,
                'username' => $request->username,
                'email'    => $guru->email,
            ]);

            if ($password) {
                $user->update(['password' => Hash::make($password)]);
            }
        }

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        // Delete linked User account first
        $guru->user?->delete();

        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
