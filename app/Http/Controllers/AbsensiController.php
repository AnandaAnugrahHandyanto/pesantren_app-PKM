<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    /**
     * Display a listing of today's attendance.
     */
    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', today()->toDateString());

        $absensis = Absensi::with('santri')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('id')
            ->get();

        return view('absensi.index', compact('absensis', 'tanggal'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        $santris = Santri::orderBy('nama')->get();

        return view('absensi.create', compact('santris'));
    }

    /**
     * Store a newly created attendance record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => ['required', 'exists:santris,id'],
            'tanggal'   => ['required', 'date'],
            'status'    => ['required', Rule::in(['hadir', 'izin', 'sakit', 'alfa'])],
        ]);

        Absensi::updateOrCreate(
            ['santri_id' => $validated['santri_id'], 'tanggal' => $validated['tanggal']],
            ['status' => $validated['status']]
        );

        return redirect()->route('absensi.index', ['tanggal' => $validated['tanggal']])
            ->with('success', 'Data absensi berhasil disimpan');
    }

    /**
     * Show the form for editing the specified attendance.
     */
    public function edit(Absensi $absensi)
    {
        $santris = Santri::orderBy('nama')->get();

        return view('absensi.edit', compact('absensi', 'santris'));
    }

    /**
     * Update the specified attendance in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'santri_id' => ['required', 'exists:santris,id'],
            'tanggal'   => [
                'required',
                'date',
                Rule::unique('absensis', 'tanggal')
                    ->where(fn ($q) => $q->where('santri_id', $request->santri_id))
                    ->ignore($absensi->id),
            ],
            'status' => ['required', Rule::in(['hadir', 'izin', 'sakit', 'alfa'])],
        ]);

        $absensi->update($validated);

        return redirect()->route('absensi.index', ['tanggal' => $validated['tanggal']])
            ->with('success', 'Data absensi berhasil diperbarui');
    }

    /**
     * Remove the specified attendance from storage.
     */
    public function destroy(Absensi $absensi)
    {
        $tanggal = $absensi->tanggal->toDateString();
        $absensi->delete();

        return redirect()->route('absensi.index', ['tanggal' => $tanggal])
            ->with('success', 'Data absensi berhasil dihapus');
    }
}
