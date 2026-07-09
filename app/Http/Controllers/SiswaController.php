<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $query = Siswa::query();

        if ($tingkat = request('tingkat')) {
            $query->where('tingkat', $tingkat);
        }

        if ($jurusan = request('jurusan')) {
            $query->where('jurusan', $jurusan);
        }

        $siswas = $query->latest()->paginate(15);
        $tingkatOptions = Siswa::tingkatOptions();
        $jurusanOptions = Siswa::jurusanOptions();

        return view('siswa.index', compact('siswas', 'tingkatOptions', 'jurusanOptions'));
    }

    public function create()
    {
        $tingkatOptions = Siswa::tingkatOptions();
        $jurusanOptions = Siswa::jurusanOptions();

        return view('siswa.create', compact('tingkatOptions', 'jurusanOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tingkat' => 'required|integer|in:7,8,9',
            'jurusan' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'nis' => 'nullable|string|max:50|unique:siswas,nis',
            'password' => 'nullable|string|min:4|max:255',
        ]);

        if (empty($validated['nis'])) {
            $validated['nis'] = Siswa::generateNIS();
        }

        $validated['kelas'] = $validated['tingkat'] . $validated['jurusan'];

        $siswa = Siswa::create($validated);

        // Bikin User account langsung
        if (!empty($validated['password'])) {
            $this->createUserForSiswa($siswa, $validated['password']);
        }

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.')
            ->with('new_siswa_nis', $siswa->nis)
            ->with('new_siswa_password', $validated['password'] ?? null);
    }

    public function edit(Siswa $siswa)
    {
        $tingkatOptions = Siswa::tingkatOptions();
        $jurusanOptions = Siswa::jurusanOptions();

        return view('siswa.edit', compact('siswa', 'tingkatOptions', 'jurusanOptions'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tingkat' => 'required|integer|in:7,8,9',
            'jurusan' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'nis' => 'nullable|string|max:50|unique:siswas,nis,' . $siswa->id,
        ]);

        if (empty($validated['nis'])) {
            $validated['nis'] = Siswa::generateNIS();
        }

        $validated['kelas'] = $validated['tingkat'] . $validated['jurusan'];

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        // Hapus relasi user dan absensi terlebih dahulu
        $siswa->user()?->delete();
        $siswa->absensis()?->delete();
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function importForm()
    {
        return view('siswa.import');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
            'default_password' => 'nullable|string|min:4|max:255',
        ]);

        try {
            $import = new \App\Imports\SiswaImport;
            \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file'));

            $results = $import->getResults();

            if ($results['success'] === 0) {
                return redirect()->route('siswa.import.form')
                    ->with('error', 'Tidak ada data siswa yang bisa diimport. Periksa format file dan pastikan ada data yang valid.');
            }

            // Bikin User account untuk siswa baru yang belum punya akun
            $password = $request->input('default_password');
            if (!empty($password)) {
                $siswaWithoutUser = Siswa::whereDoesntHave('user')
                    ->latest()
                    ->take($results['success'])
                    ->get();

                $usersCreated = 0;
                foreach ($siswaWithoutUser as $siswa) {
                    $this->createUserForSiswa($siswa, $password);
                    $usersCreated++;
                }
            }

            $msg = "Berhasil mengimport {$results['success']} data siswa.";
            if (!empty($password) && isset($usersCreated) && $usersCreated > 0) {
                $msg .= " Akun login ({$usersCreated}) berhasil dibuat.";
            } elseif (empty($password)) {
                $msg .= ' Akun login belum dibuat — jalankan `php artisan siswa:generate-users` untuk membuatnya.';
            }
            if ($results['skipped'] > 0) {
                $msg .= " {$results['skipped']} baris dilewati.";
            }

            return redirect()->route('siswa.index')
                ->with('success', $msg);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $msg = 'Gagal import: ' . ($failures->first()->errors()[0] ?? 'Format file tidak sesuai.');
            return redirect()->route('siswa.import.form')
                ->with('error', $msg);
        } catch (\Exception $e) {
            return redirect()->route('siswa.import.form')
                ->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SiswaTemplateExport,
            'template-import-siswa.xlsx'
        );
    }

    /**
     * Bikin User account buat login siswa.
     */
    private function createUserForSiswa(Siswa $siswa, string $password): User
    {
        $nis = $siswa->nis ?? 'NIS-' . str_pad((string) $siswa->id, 6, '0', STR_PAD_LEFT);

        return User::create([
            'name' => $siswa->nama_lengkap,
            'nis' => $nis,
            'email' => null,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'role' => 'siswa',
            'siswa_id' => $siswa->id,
        ]);
    }

    /**
     * Siswa dashboard — menampilkan absensi milik siswa yang login.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil data absensi untuk siswa ini
        $absensis = \App\Models\Absensi::where('siswa_id', $user->siswa_id)
            ->with('mataPelajaran')
            ->orderBy('tanggal', 'desc')
            ->limit(30)
            ->get();

        $stats = [
            'total' => $absensis->count(),
            'hadir' => $absensis->where('status', 'hadir')->count(),
            'izin'  => $absensis->where('status', 'izin')->count(),
            'sakit' => $absensis->where('status', 'sakit')->count(),
            'alfa'  => $absensis->where('status', 'alfa')->count(),
        ];

        // Ambil data SPP tagihan
        $tagihan = \App\Models\SppBill::where('siswa_id', $user->siswa_id)
            ->where('tahun', now()->year)
            ->orderBy('bulan')
            ->get();

        $statSpp = [
            'lunas' => $tagihan->where('status', 'lunas')->count(),
            'total' => $tagihan->count(),
        ];

        return view('siswa.dashboard', compact('absensis', 'stats', 'tagihan', 'statSpp'));
    }
}
