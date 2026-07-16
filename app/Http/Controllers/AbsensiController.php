<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    private const STATUS_OPTIONS = ['hadir', 'izin', 'sakit', 'alfa'];

    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', today()->toDateString());
        $mataPelajaranId = $request->query('mata_pelajaran_id');
        $selectedMataPelajaran = $mataPelajaranId
            ? MataPelajaran::find($mataPelajaranId)
            : null;
        $kelas = $request->query('kelas_v2');
        $rombel = $request->query('rombel');

        $mataPelajaranOptions = MataPelajaran::orderBy('kelas_v2')->orderBy('rombel')->orderBy('nama')->get();
        $kelasOptions = Siswa::select('kelas_v2')->distinct()->pluck('kelas_v2')->filter()->sort();
        $rombelOptions = Siswa::select('rombel')->distinct()->pluck('rombel')->filter()->sort();

        $siswas = collect();
        $existingAbsensi = collect();
        $statusBySiswa = collect();
        $hasExistingAbsensi = false;
        $allAbsensiComplete = false;
        $lastUpdatedAt = null;
        $statusCounts = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alfa' => 0];
        $totalSiswa = 0;
        $existingCount = 0;

        if ($request->filled('mata_pelajaran_id') && $request->filled('kelas_v2') && $request->filled('rombel')) {
            $siswas = Siswa::query()
                ->select(['id', 'nama_lengkap', 'kelas_v2', 'rombel', 'jenis_kelamin'])
                ->where('kelas_v2', (int)$kelas)
                ->where('rombel', $rombel)
                ->orderBy('nama_lengkap')
                ->get();

            $existingAbsensi = Absensi::query()
                ->select(['siswa_id', 'status', 'updated_at'])
                ->whereDate('tanggal', $tanggal)
                ->where('mata_pelajaran_id', $mataPelajaranId)
                ->whereIn('siswa_id', $siswas->pluck('id'))
                ->get();

            $statusBySiswa = $existingAbsensi->pluck('status', 'siswa_id');
            $existingCount = $statusBySiswa->count();
            $totalSiswa = $siswas->count();
            $hasExistingAbsensi = $existingCount > 0;
            $allAbsensiComplete = $totalSiswa > 0 && $existingCount === $totalSiswa;
            $lastUpdatedAt = $existingAbsensi->max('updated_at');
            $statusCounts = [
                'hadir' => $existingAbsensi->where('status', 'hadir')->count(),
                'izin' => $existingAbsensi->where('status', 'izin')->count(),
                'sakit' => $existingAbsensi->where('status', 'sakit')->count(),
                'alfa' => $existingAbsensi->where('status', 'alfa')->count(),
            ];
        }

        return view('absensi.index', [
            'siswas' => $siswas,
            'tanggal' => $tanggal,
            'mataPelajaranOptions' => $mataPelajaranOptions,
            'mataPelajaranId' => $mataPelajaranId,
            'selectedMataPelajaran' => $selectedMataPelajaran,
            'kelas_v2' => $kelas,
            'rombel' => $rombel,
            'statusOptions' => self::STATUS_OPTIONS,
            'kelasOptions' => $kelasOptions,
            'rombelOptions' => $rombelOptions,
            'statusBySiswa' => $statusBySiswa,
            'existingCount' => $existingCount,
            'totalSiswa' => $totalSiswa,
            'hasExistingAbsensi' => $hasExistingAbsensi,
            'allAbsensiComplete' => $allAbsensiComplete,
            'lastUpdatedAt' => $lastUpdatedAt,
            'absensiMode' => $hasExistingAbsensi ? 'edit' : 'create',
            'statusCounts' => $statusCounts,
        ]);
    }

    public function create(Request $request)
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();
        $mataPelajaranId = $request->query('mata_pelajaran_id', '');

        return view('absensi.create', compact('siswas', 'mataPelajaranId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'tanggal' => [
                'required',
                'date',
                Rule::unique('absensis', 'tanggal')
                    ->where(fn ($q) => $q->where('siswa_id', $request->siswa_id)->where('mata_pelajaran_id', $request->mata_pelajaran_id)),
            ],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
        ]);

        Absensi::updateOrCreate(
            [
                'siswa_id' => $validated['siswa_id'],
                'tanggal' => $validated['tanggal'],
                'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
            ],
            ['status' => $validated['status']]
        );

        return redirect()->route('absensi.index', ['tanggal' => $validated['tanggal'], 'mata_pelajaran_id' => $validated['mata_pelajaran_id']])
            ->with('success', 'Data absensi berhasil disimpan');
    }

    public function massStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
            'form_mode' => ['nullable', Rule::in(['create', 'edit'])],
            'absensi' => ['required', 'array', 'min:1'],
            'absensi.*' => ['required', Rule::in(self::STATUS_OPTIONS)],
        ]);

        $siswaIds = array_keys($validated['absensi']);

        DB::transaction(function () use ($validated, $siswaIds): void {
            foreach ($siswaIds as $siswaId) {
                Absensi::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'tanggal' => $validated['tanggal'],
                        'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
                    ],
                    ['status' => $validated['absensi'][$siswaId]]
                );
            }
        });

        return redirect()->route('absensi.index', [
            'tanggal' => $validated['tanggal'],
            'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
        ])->with('success', 'Absensi berhasil diperbarui.');
    }

    public function edit(Absensi $absensi)
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();

        return view('absensi.edit', compact('absensi', 'siswas'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'tanggal' => [
                'required',
                'date',
                Rule::unique('absensis', 'tanggal')
                    ->where(fn ($q) => $q->where('siswa_id', $request->siswa_id)->where('mata_pelajaran_id', $request->mata_pelajaran_id))
                    ->ignore($absensi->id),
            ],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajarans,id'],
        ]);

        $absensi->update($validated);

        return redirect()->route('absensi.index', ['tanggal' => $validated['tanggal'], 'mata_pelajaran_id' => $validated['mata_pelajaran_id']])
            ->with('success', 'Data absensi berhasil diperbarui');
    }

    public function destroy(Absensi $absensi)
    {
        $tanggal = $absensi->tanggal->toDateString();
        $mataPelajaranId = $absensi->mata_pelajaran_id;
        $absensi->delete();

        return redirect()->route('absensi.index', ['tanggal' => $tanggal, 'mata_pelajaran_id' => $mataPelajaranId])
            ->with('success', 'Data absensi berhasil dihapus');
    }
}
