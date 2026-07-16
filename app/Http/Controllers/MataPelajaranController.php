<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mataPelajarans = MataPelajaran::with('guru')->orderBy('kelas_v2')->orderBy('rombel')->orderBy('nama')->get();

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
            'kelas_v2' => ['required', 'integer', 'in:7,8,9'],
            'rombel' => ['required', 'string', 'max:5'],
            'guru_id' => ['required', 'exists:gurus,id'],
        ]);

        // Cek unique (nama + kelas_v2 + rombel)
        $exists = MataPelajaran::where('nama', $validated['nama'])
            ->where('kelas_v2', $validated['kelas_v2'])
            ->where('rombel', $validated['rombel'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['nama' => "Mata pelajaran '{$validated['nama']}' untuk kelas_v2 '{$validated['kelas_v2']}-{$validated['rombel']}' sudah ada."])
                ->withInput();
        }

        $validated['kelas'] = $validated['kelas_v2'];
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
            'kelas_v2' => ['required', 'integer', 'in:7,8,9'],
            'rombel' => ['required', 'string', 'max:5'],
            'guru_id' => ['required', 'exists:gurus,id'],
        ]);

        // Cek unique (nama + kelas_v2) kecuali dirinya sendiri
        $exists = MataPelajaran::where('nama', $validated['nama'])
            ->where('kelas_v2', $validated['kelas_v2'])
            ->where('id', '!=', $mataPelajaran->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['nama' => "Mata pelajaran '{$validated['nama']}' untuk kelas_v2 '{$validated['kelas_v2']}' sudah ada."])
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
                'delete' => "Tidak bisa menghapus '{$mataPelajaran->nama}' kelas_v2 {$mataPelajaran->kelas_v2}: masih ada {$absensiCount} data absensi yang menggunakannya."
            ]);
        }

        $mataPelajaran->delete();

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
