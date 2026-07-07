<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    private const KATEGORI_OPTIONS = ['pelajaran', 'ekstrakurikuler', 'upacara', 'kegiatan_khusus'];

    private const STATUS_OPTIONS = ['hadir', 'izin', 'sakit', 'alfa'];

    /**
     * Display a listing of today's attendance.
     */
    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', today()->toDateString());
        $kategori = $request->query('kategori', self::KATEGORI_OPTIONS[0]);

        if (! in_array($kategori, self::KATEGORI_OPTIONS, true)) {
            $kategori = self::KATEGORI_OPTIONS[0];
        }

        $siswas = Siswa::query()
            ->select(['id', 'nama_lengkap', 'kelas', 'jenis_kelamin'])
            ->orderBy('kelas')
            ->orderBy('nama_lengkap')
            ->get();

        $existingAbsensi = Absensi::query()
            ->select(['siswa_id', 'status', 'updated_at'])
            ->whereDate('tanggal', $tanggal)
            ->where('kategori', $kategori)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get();

        $statusBySiswa = $existingAbsensi->pluck('status', 'siswa_id');
        $existingCount = $statusBySiswa->count();
        $totalSiswa = $siswas->count();
        $hasExistingAbsensi = $existingCount > 0;
        $allAbsensiComplete = $totalSiswa > 0 && $existingCount === $totalSiswa;
        $lastUpdatedAt = $existingAbsensi->max('updated_at');
        $kelasOptions = $siswas->pluck('kelas')->filter()->unique()->sort()->values();

        return view('absensi.index', [
            'siswas' => $siswas,
            'tanggal' => $tanggal,
            'kategori' => $kategori,
            'kategoriOptions' => self::KATEGORI_OPTIONS,
            'statusOptions' => self::STATUS_OPTIONS,
            'kelasOptions' => $kelasOptions,
            'statusBySiswa' => $statusBySiswa,
            'existingCount' => $existingCount,
            'totalSiswa' => $totalSiswa,
            'hasExistingAbsensi' => $hasExistingAbsensi,
            'allAbsensiComplete' => $allAbsensiComplete,
            'lastUpdatedAt' => $lastUpdatedAt,
            'absensiMode' => $hasExistingAbsensi ? 'edit' : 'create',
        ]);
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create(Request $request)
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();
        $kategori = $request->query('kategori', '');

        return view('absensi.create', compact('siswas', 'kategori'));
    }

    /**
     * Store a newly created attendance record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'tanggal' => [
                'required',
                'date',
                Rule::unique('absensis', 'tanggal')
                    ->where(fn ($q) => $q->where('siswa_id', $request->siswa_id)->where('kategori', $request->kategori)),
            ],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'kategori' => ['required', Rule::in(self::KATEGORI_OPTIONS)],
        ]);

        Absensi::updateOrCreate(
            [
                'siswa_id' => $validated['siswa_id'],
                'tanggal' => $validated['tanggal'],
                'kategori' => $validated['kategori'],
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
            'form_mode' => ['nullable', Rule::in(['create', 'edit'])],
            'absensi' => ['required', 'array', 'min:1'],
            'absensi.*' => ['required', Rule::in(self::STATUS_OPTIONS)],
        ], [
            'absensi.required' => 'Data absensi tidak boleh kosong.',
            'absensi.*.required' => 'Semua siswa harus memiliki status absensi.',
            'absensi.*.in' => 'Status absensi tidak valid.',
        ]);

        $siswaKeys = array_keys($validated['absensi']);
        $invalidSiswaKey = collect($siswaKeys)
            ->contains(fn ($id) => ! is_numeric($id) || (int) $id <= 0);

        if ($invalidSiswaKey) {
            return back()
                ->withErrors(['absensi' => 'Format data siswa tidak valid.'])
                ->withInput();
        }

        $siswaIds = collect($siswaKeys)
            ->map(fn ($id) => (int) $id)
            ->values();

        $existingCountForScope = Absensi::query()
            ->whereDate('tanggal', $validated['tanggal'])
            ->where('kategori', $validated['kategori'])
            ->count();
        $hasExistingForScope = $existingCountForScope > 0;
        $isEditMode = ($validated['form_mode'] ?? 'create') === 'edit';

        if ($hasExistingForScope && ! $isEditMode) {
            return redirect()->route('absensi.index', [
                'tanggal' => $validated['tanggal'],
                'kategori' => $validated['kategori'],
            ])->with('absensi_exists_warning', [
                'kategori' => $validated['kategori'],
                'tanggal' => $validated['tanggal'],
            ]);
        }

        $validSiswaCount = Siswa::query()->whereIn('id', $siswaIds)->count();
        if ($validSiswaCount !== $siswaIds->count()) {
            return back()
                ->withErrors(['absensi' => 'Terdapat data siswa yang tidak valid.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $siswaIds): void {
            foreach ($siswaIds as $siswaId) {
                Absensi::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'tanggal' => $validated['tanggal'],
                        'kategori' => $validated['kategori'],
                    ],
                    ['status' => $validated['absensi'][$siswaId]]
                );
            }
        });

        return redirect()->route('absensi.index', [
            'tanggal' => $validated['tanggal'],
            'kategori' => $validated['kategori'],
        ])->with('success', $hasExistingForScope ? 'Absensi massal berhasil diperbarui.' : 'Absensi massal berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified attendance.
     */
    public function edit(Absensi $absensi)
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();

        return view('absensi.edit', compact('absensi', 'siswas'));
    }

    /**
     * Update the specified attendance in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'tanggal' => [
                'required',
                'date',
                Rule::unique('absensis', 'tanggal')
                    ->where(fn ($q) => $q->where('siswa_id', $request->siswa_id)->where('kategori', $request->kategori))
                    ->ignore($absensi->id),
            ],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'kategori' => ['required', Rule::in(self::KATEGORI_OPTIONS)],
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
        $tanggal = $absensi->tanggal->toDateString();
        $kategori = $absensi->kategori;
        $absensi->delete();

        return redirect()->route('absensi.index', ['tanggal' => $tanggal, 'kategori' => $kategori])
            ->with('success', 'Data absensi berhasil dihapus');
    }
}
