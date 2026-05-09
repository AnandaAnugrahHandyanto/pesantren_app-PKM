<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Santri;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    private const KATEGORI_OPTIONS = ['sekolah', 'halaqoh', 'berkebun', 'dirosah'];
    private const STATUS_OPTIONS = ['hadir', 'izin', 'sakit', 'alfa'];

    /**
     * Display a listing of today's attendance.
     */
    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', today()->toDateString());
        $kategori = $request->query('kategori', self::KATEGORI_OPTIONS[0]);

        if (!in_array($kategori, self::KATEGORI_OPTIONS, true)) {
            $kategori = self::KATEGORI_OPTIONS[0];
        }

        $santris = Santri::query()
            ->select(['id', 'nama_lengkap', 'kelas', 'jenis_kelamin'])
            ->orderBy('kelas')
            ->orderBy('nama_lengkap')
            ->get();

        $existingAbsensi = Absensi::query()
            ->select(['santri_id', 'status'])
            ->whereDate('tanggal', $tanggal)
            ->where('kategori', $kategori)
            ->whereIn('santri_id', $santris->pluck('id'))
            ->get();

        $statusBySantri = $existingAbsensi->pluck('status', 'santri_id');
        $kelasOptions = $santris->pluck('kelas')->filter()->unique()->sort()->values();

        return view('absensi.index', [
            'santris' => $santris,
            'tanggal' => $tanggal,
            'kategori' => $kategori,
            'kategoriOptions' => self::KATEGORI_OPTIONS,
            'statusOptions' => self::STATUS_OPTIONS,
            'statusBySantri' => $statusBySantri,
            'kelasOptions' => $kelasOptions,
        ]);
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create(Request $request)
    {
        $santris  = Santri::orderBy('nama_lengkap')->get();
        $kategori = $request->query('kategori', '');

        return view('absensi.create', compact('santris', 'kategori'));
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
            'kategori'  => ['required', Rule::in(['sekolah', 'halaqoh', 'berkebun', 'dirosah'])],
        ]);

        Absensi::updateOrCreate(
            [
                'santri_id' => $validated['santri_id'],
                'tanggal'   => $validated['tanggal'],
                'kategori'  => $validated['kategori'],
            ],
            ['status' => $validated['status']]
        );

        return redirect()->route('absensi.index', ['tanggal' => $validated['tanggal'], 'kategori' => $validated['kategori']])
            ->with('success', 'Data absensi berhasil disimpan');
    }

    /**
     * Store mass attendance in storage.
     */
    public function massStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'kategori' => ['required', Rule::in(self::KATEGORI_OPTIONS)],
            'absensi' => ['required', 'array', 'min:1'],
            'absensi.*' => ['required', Rule::in(self::STATUS_OPTIONS)],
        ], [
            'absensi.required' => 'Data absensi tidak boleh kosong.',
            'absensi.*.required' => 'Semua santri harus memiliki status absensi.',
            'absensi.*.in' => 'Status absensi tidak valid.',
        ]);

        $santriIds = collect(array_keys($validated['absensi']))
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->values();

        $validSantriCount = Santri::query()->whereIn('id', $santriIds)->count();
        if ($validSantriCount !== $santriIds->count()) {
            return back()
                ->withErrors(['absensi' => 'Terdapat data santri yang tidak valid.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $santriIds): void {
            foreach ($santriIds as $santriId) {
                Absensi::updateOrCreate(
                    [
                        'santri_id' => $santriId,
                        'tanggal' => $validated['tanggal'],
                        'kategori' => $validated['kategori'],
                    ],
                    ['status' => $validated['absensi'][$santriId]]
                );
            }
        });

        return redirect()->route('absensi.index', [
            'tanggal' => $validated['tanggal'],
            'kategori' => $validated['kategori'],
        ])->with('success', 'Absensi massal berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified attendance.
     */
    public function edit(Absensi $absensi)
    {
        $santris = Santri::orderBy('nama_lengkap')->get();

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
                    ->where(fn ($q) => $q->where('santri_id', $request->santri_id)->where('kategori', $request->kategori))
                    ->ignore($absensi->id),
            ],
            'status'   => ['required', Rule::in(['hadir', 'izin', 'sakit', 'alfa'])],
            'kategori' => ['required', Rule::in(['sekolah', 'halaqoh', 'berkebun', 'dirosah'])],
        ]);

        $absensi->update($validated);

        return redirect()->route('absensi.index', ['tanggal' => $validated['tanggal'], 'kategori' => $validated['kategori']])
            ->with('success', 'Data absensi berhasil diperbarui');
    }

    /**
     * Remove the specified attendance from storage.
     */
    public function destroy(Absensi $absensi)
    {
        $tanggal  = $absensi->tanggal->toDateString();
        $kategori = $absensi->kategori;
        $absensi->delete();

        return redirect()->route('absensi.index', ['tanggal' => $tanggal, 'kategori' => $kategori])
            ->with('success', 'Data absensi berhasil dihapus');
    }
}
