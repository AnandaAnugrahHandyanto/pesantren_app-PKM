<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mataPelajarans = MataPelajaran::orderBy('kelas')->orderBy('nama')->get();

        return view('mata-pelajaran.index', compact('mataPelajarans'));
    }

    public function create()
    {
        return view('mata-pelajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        // Cek unique (nama + kelas)
        $exists = MataPelajaran::where('nama', $validated['nama'])
            ->where('kelas', $validated['kelas'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['nama' => "Mata pelajaran '{$validated['nama']}' untuk kelas '{$validated['kelas']}' sudah ada."])
                ->withInput();
        }

        MataPelajaran::create($validated);

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
        ]);

        // Cek unique (nama + kelas) kecuali dirinya sendiri
        $exists = MataPelajaran::where('nama', $validated['nama'])
            ->where('kelas', $validated['kelas'])
            ->where('id', '!=', $mataPelajaran->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['nama' => "Mata pelajaran '{$validated['nama']}' untuk kelas '{$validated['kelas']}' sudah ada."])
                ->withInput();
        }

        $mataPelajaran->update($validated);

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $absensiCount = $mataPelajaran->absensis()->count();
        if ($absensiCount > 0) {
            return back()->withErrors([
                'delete' => "Tidak bisa menghapus '{$mataPelajaran->nama}' kelas {$mataPelajaran->kelas}: masih ada {$absensiCount} data absensi yang menggunakannya."
            ]);
        }

        $mataPelajaran->delete();

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
