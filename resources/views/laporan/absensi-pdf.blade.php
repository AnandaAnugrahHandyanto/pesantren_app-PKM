<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Absensi</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11pt; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .school-name { font-size: 20pt; font-weight: bold; margin-bottom: 5px; }
        .school-subtitle { font-size: 14pt; margin-bottom: 10px; }
        .report-title { font-size: 16pt; font-weight: bold; text-decoration: underline; }
        
        .info-table { width: 100%; margin-bottom: 20px; font-size: 11pt; }
        .info-table td { padding: 3px 0; }
        .info-label { font-weight: bold; width: 150px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f2f2f2; font-weight: bold; border: 0.5pt solid #000; padding: 8px; text-align: left; }
        td { border: 0.5pt solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">Sekolah App</div>
        <div class="school-subtitle">Sistem Informasi Akademik</div>
        <div class="report-title">Laporan Absensi</div>
    </div>

    <table class="info-table" style="border: none;">
        <tr>
            <td class="info-label" style="border: none;">Tanggal Cetak</td>
            <td style="border: none;">: {{ now()->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <td class="info-label" style="border: none;">Filter Tanggal</td>
            <td style="border: none;">: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="info-label" style="border: none;">Mata Pelajaran</td>
            <td style="border: none;">: {{ $absensis->first()->mataPelajaran->nama ?? 'Semua Mata Pelajaran' }}</td>
        </tr>
        <tr>
            <td class="info-label" style="border: none;">Kelas</td>
            <td style="border: none;">: {{ $filter['kelas'] ?? 'Semua Kelas' }}</td>
        </tr>
        <tr>
            <td class="info-label" style="border: none;">Dicetak Oleh</td>
            <td style="border: none;">: {{ auth()->user()->name }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Mata Pelajaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensis as $index => $absensi)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $absensi->siswa->nis ?? '-' }}</td>
                    <td>{{ $absensi->siswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $absensi->mataPelajaran->nama ?? '-' }}</td>
                    <td>{{ ucfirst($absensi->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
