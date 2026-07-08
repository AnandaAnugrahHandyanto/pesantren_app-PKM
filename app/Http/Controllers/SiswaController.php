<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::query();

        // Filter by tingkat (7, 8, 9)
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter by jurusan (A, B, C, D, E)
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        $siswas = $query->latest()->paginate(25);

        $tingkatOptions = Siswa::tingkatOptions();
        $jurusanOptions = Siswa::jurusanOptions();

        return view('siswa.index', compact('siswas', 'tingkatOptions', 'jurusanOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tingkatOptions = Siswa::tingkatOptions();
        $jurusanOptions = Siswa::jurusanOptions();
        return view('siswa.create', compact('tingkatOptions', 'jurusanOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['nullable', 'string', 'max:50', Rule::unique('siswas', 'nis')],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'integer', 'in:7,8,9'],
            'jurusan' => ['required', 'string', 'size:1', Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
        ]);

        $validated['nis'] = $validated['nis'] ?? Siswa::generateNIS();
        $validated['kelas'] = $validated['tingkat'] . $validated['jurusan'];

        Siswa::create($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan (NIS: ' . $validated['nis'] . ')');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $tingkatOptions = Siswa::tingkatOptions();
        $jurusanOptions = Siswa::jurusanOptions();
        return view('siswa.edit', compact('siswa', 'tingkatOptions', 'jurusanOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => ['nullable', 'string', 'max:50', Rule::unique('siswas', 'nis')->ignore($siswa->id)],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'integer', 'in:7,8,9'],
            'jurusan' => ['required', 'string', 'size:1', Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
        ]);

        $validated['nis'] = $validated['nis'] ?? $siswa->nis;
        $validated['kelas'] = $validated['tingkat'] . $validated['jurusan'];

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }

    /**
     * Download a blank CSV template for the siswa import.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_siswa.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['nis', 'nama_lengkap', 'tingkat', 'jurusan', 'jenis_kelamin']);
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for importing siswa data.
     */
    public function importForm()
    {
        return view('siswa.import');
    }

    /**
     * Process the Excel import.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,csv'],
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));

            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
}