<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Absensi Semester {{ $semester }} – {{ $tahunAjaran }}/{{ $tahunAjaran + 1 }}</title>
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
    <h1>Rekap Absensi Semester {{ $semester }}</h1>
    <p class="subtitle">
        Tahun Ajaran {{ $tahunAjaran }}/{{ $tahunAjaran + 1 }} &mdash;
        Periode {{ \Carbon\Carbon::parse($from)->translatedFormat('d F Y') }}
        s.d. {{ \Carbon\Carbon::parse($to)->translatedFormat('d F Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th style="width:40px">No</th>
                <th>Nama Santri</th>
                <th>Kelas</th>
                <th class="num">Hadir</th>
                <th class="num">Izin</th>
                <th class="num">Sakit</th>
                <th class="num">Alfa</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekap as $i => $santri)
                <tr>
                    <td class="num">{{ $i + 1 }}</td>
                    <td>{{ $santri->nama_lengkap }}</td>
                    <td>{{ $santri->kelas }}</td>
                    <td class="num">{{ $santri->hadir }}</td>
                    <td class="num">{{ $santri->izin }}</td>
                    <td class="num">{{ $santri->sakit }}</td>
                    <td class="num">{{ $santri->alfa }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#888;">Tidak ada data santri.</td>
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
        <button onclick="window.print()">🖨 Cetak</button>
        <a href="{{ route('rekap.absensi', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}">
            ← Kembali
        </a>
    </div>

    <script>
        window.onload = function () { window.print(); };
    </script>
</body>
</html>
