<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Absensi Semester {{ $semesterLabel }} – {{ $tahunAjaran }}/{{ $tahunAjaran + 1 }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #111; padding: 24px; }
        h1 { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 4px; }
        .subtitle { text-align: center; font-size: 12px; color: #444; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #bbb; padding: 6px 10px; text-align: left; }
        thead tr { background: #f0f0f0; }
        th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; }
        td.num { text-align: center; }
        tfoot td { font-weight: bold; background: #f9f9f9; }
        .no-print { margin-top: 20px; text-align: center; }
        .no-print button {
            padding: 8px 20px; background: #4f46e5; color: #fff;
            border: none; border-radius: 6px; cursor: pointer; font-size: 13px;
        }
        .no-print a {
            margin-left: 12px; color: #4f46e5; font-size: 13px; text-decoration: underline;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <h1>Rekap Absensi Semester {{ $semesterLabel }}</h1>
    <p class="subtitle">
        Tahun Ajaran {{ $tahunAjaran }}/{{ $tahunAjaran + 1 }} &mdash;
        Periode {{ \Carbon\Carbon::parse($from)->translatedFormat('d F Y') }}
        s.d. {{ \Carbon\Carbon::parse($to)->translatedFormat('d F Y') }}
        @if ($mataPelajaranId) &mdash; {{ $mataPelajaranOptions->firstWhere('id', (int) $mataPelajaranId)?->nama ?? 'Mata Pelajaran' }} @endif
    </p>

    <table>
        <thead>
            <tr>
                <th style="width:40px">No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th class="num">Hadir</th>
                <th class="num">Izin</th>
                <th class="num">Sakit</th>
                <th class="num">Alfa</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekap as $i => $siswa)
                <tr>
                    <td class="num">{{ $i + 1 }}</td>
                    <td>{{ $siswa->nama_lengkap }}</td>
                    <td>{{ $siswa->kelas }}</td>
                    <td class="num">{{ $siswa->hadir }}</td>
                    <td class="num">{{ $siswa->izin }}</td>
                    <td class="num">{{ $siswa->sakit }}</td>
                    <td class="num">{{ $siswa->alfa }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#888;">Tidak ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
        @if ($rekap->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="3" style="text-align:right">Total</td>
                <td class="num">{{ $rekap->sum('hadir') }}</td>
                <td class="num">{{ $rekap->sum('izin') }}</td>
                <td class="num">{{ $rekap->sum('sakit') }}</td>
                <td class="num">{{ $rekap->sum('alfa') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm text-white/80 ring-1 ring-white/20 hover:bg-white/20">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
            </svg>
            Cetak
        </button>
        <a href="{{ route('laporan.absensi', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran, 'mata_pelajaran_id' => $mataPelajaranId]) }}">
            ← Kembali
        </a>
    </div>

    <script>
        window.onload = function () { window.print(); };
    </script>
</body>
</html>
