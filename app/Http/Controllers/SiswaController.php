<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\SppBill;
use App\Models\User;
use App\Exports\SiswaTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    private function getDropdownOptions()
    {
        return [
            'kelasOptions' => [7, 8, 9],
            'rombelOptions' => ['A', 'B', 'C', 'D', 'E'],
        ];
    }

    public function index()
    {
        $query = Siswa::query();

        if ($kelas = request('kelas_v2')) {
            $query->where('kelas_v2', $kelas);
        }

        if ($rombel = request('rombel')) {
            $query->where('rombel', $rombel);
        }

        $siswas = $query->latest()->paginate(15);
        $options = $this->getDropdownOptions();

        return view('siswa.index', array_merge(compact('siswas'), $options));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $absensis = Absensi::where('siswa_id', $user->siswa_id)
            ->with('mataPelajaran')
            ->orderBy('tanggal', 'desc')
            ->limit(30)
            ->get();

        $stats = [
            'total' => $absensis->count(),
            'hadir' => $absensis->where('status', 'hadir')->count(),
            'izin' => $absensis->where('status', 'izin')->count(),
            'sakit' => $absensis->where('status', 'sakit')->count(),
            'alfa' => $absensis->where('status', 'alfa')->count(),
        ];

        $tagihan = SppBill::where('siswa_id', $user->siswa_id)
            ->where('tahun', now()->year)
            ->orderBy('bulan')
            ->get();

        $statSpp = [
            'lunas' => $tagihan->where('status', 'lunas')->count(),
            'total' => $tagihan->count(),
        ];

        return view('siswa.dashboard', compact('absensis', 'stats', 'tagihan', 'statSpp'));
    }

    public function create()
    {
        $options = $this->getDropdownOptions();
        return view('siswa.create', $options);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kelas_v2' => 'required|integer|in:7,8,9',
            'rombel' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'nis' => 'nullable|string|max:50|unique:siswas,nis',
            'password' => 'nullable|string|min:4|max:255',
        ]);

        if (empty($validated['nis'])) {
            $validated['nis'] = Siswa::generateNIS();
        }

        $validated['kelas'] = $validated['kelas_v2'].$validated['rombel'];
        
        $siswa = Siswa::create($validated);

        if (! empty($validated['password'])) {
            $this->createUserForSiswa($siswa, $validated['password']);
        }

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $options = $this->getDropdownOptions();
        return view('siswa.edit', array_merge(compact('siswa'), $options));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kelas_v2' => 'required|integer|in:7,8,9',
            'rombel' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'nis' => 'nullable|string|max:50|unique:siswas,nis,'.$siswa->id,
        ]);

        $validated['kelas'] = $validated['kelas_v2'].$validated['rombel'];
        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function updatePassword(Request $request, Siswa $siswa)
    {
        $request->validate([
            'password' => 'required|string|min:4|max:255',
        ]);

        $user = $siswa->user;
        if (! $user) {
            return back()->with('error', 'Siswa ini belum memiliki akun login.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password siswa berhasil direset.');
    }

    public function destroy(Siswa $siswa)
    {
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
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'default_password' => 'nullable|string',
        ]);

        try {
            $defaultPassword = trim((string) $request->input('default_password'));
            Excel::import(new SiswaImport($defaultPassword), $request->file('file'));
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(
            new SiswaTemplateExport(),
            'template_import_siswa.xlsx'
        );
    }

    private function createUserForSiswa(Siswa $siswa, string $password): User
    {
        return \App\Services\SiswaService::createUserForSiswa($siswa, $password);
    }
}
