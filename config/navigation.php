<?php

return [
    'admin' => [
        'dashboard' => [
            'index' => ['sidebar' => 'Dashboard', 'title' => 'Dashboard Admin', 'breadcrumb' => 'Platform > Dashboard'],
        ],
        'siswa' => [
            'index' => ['sidebar' => 'Siswa', 'title' => 'Manajemen Siswa', 'breadcrumb' => 'Data > Siswa'],
            'create' => ['sidebar' => 'Siswa', 'title' => 'Registrasi Siswa', 'breadcrumb' => 'Data > Siswa > Tambah'],
            'edit' => ['sidebar' => 'Siswa', 'title' => 'Ubah Data Siswa', 'breadcrumb' => 'Data > Siswa > Edit'],
        ],
        'guru' => [
            'index' => ['sidebar' => 'Guru', 'title' => 'Manajemen Guru', 'breadcrumb' => 'Data > Guru'],
            'create' => ['sidebar' => 'Guru', 'title' => 'Registrasi Guru', 'breadcrumb' => 'Data > Guru > Tambah'],
            'edit' => ['sidebar' => 'Guru', 'title' => 'Ubah Data Guru', 'breadcrumb' => 'Data > Guru > Edit'],
        ],
        'mata-pelajaran' => [
            'index' => ['sidebar' => 'Mata Pelajaran', 'title' => 'Katalog Mata Pelajaran', 'breadcrumb' => 'Data > Mata Pelajaran'],
            'create' => ['sidebar' => 'Mata Pelajaran', 'title' => 'Tambah Mata Pelajaran', 'breadcrumb' => 'Data > Mata Pelajaran > Tambah'],
            'edit' => ['sidebar' => 'Mata Pelajaran', 'title' => 'Ubah Mata Pelajaran', 'breadcrumb' => 'Data > Mata Pelajaran > Edit'],
        ],
        'jadwal' => [
            'index' => ['sidebar' => 'Jadwal Pelajaran', 'title' => 'Penyusunan Jadwal', 'breadcrumb' => 'Akademik > Jadwal Pelajaran'],
            'create' => ['sidebar' => 'Jadwal Pelajaran', 'title' => 'Tambah Jadwal Pelajaran', 'breadcrumb' => 'Akademik > Jadwal Pelajaran > Tambah'],
            'edit' => ['sidebar' => 'Jadwal Pelajaran', 'title' => 'Ubah Jadwal Pelajaran', 'breadcrumb' => 'Akademik > Jadwal Pelajaran > Edit'],
        ],
        'absensi' => [
            'index' => ['sidebar' => 'Absen', 'title' => 'Pengisian Absensi', 'breadcrumb' => 'Absensi > Absen'],
        ],
        'laporan' => [
            'absensi' => ['sidebar' => 'Laporan', 'title' => 'Laporan Absensi', 'breadcrumb' => 'Absensi > Laporan'],
        ],
        'keuangan' => [
            'index' => ['sidebar' => 'Transaksi', 'title' => 'Manajemen Keuangan', 'breadcrumb' => 'Keuangan > Transaksi'],
            'create' => ['sidebar' => 'Transaksi', 'title' => 'Tambah Transaksi', 'breadcrumb' => 'Keuangan > Transaksi > Tambah'],
            'edit' => ['sidebar' => 'Transaksi', 'title' => 'Ubah Transaksi', 'breadcrumb' => 'Keuangan > Transaksi > Edit'],
        ],
        'spp' => [
            'index' => ['sidebar' => 'SPP', 'title' => 'Pembayaran SPP', 'breadcrumb' => 'Keuangan > SPP'],
        ],
    ],
    'guru' => [
        'dashboard' => [
            'index' => ['sidebar' => 'Dashboard', 'title' => 'Dashboard Guru', 'breadcrumb' => 'Platform > Dashboard'],
        ],
        'absensi' => [
            'index' => ['sidebar' => 'Absen', 'title' => 'Pengisian Absensi', 'breadcrumb' => 'Absensi > Absen'],
        ],
        'laporan' => [
            'absensi' => ['sidebar' => 'Laporan', 'title' => 'Laporan Absensi', 'breadcrumb' => 'Absensi > Laporan'],
        ],
        'jadwal' => [
            'index' => ['sidebar' => 'Jadwal', 'title' => 'Jadwal Mengajar', 'breadcrumb' => 'Akademik > Jadwal'],
        ],
    ],
    'siswa' => [
        'dashboard' => [
            'index' => ['sidebar' => 'Dashboard', 'title' => 'Dashboard Siswa', 'breadcrumb' => 'Platform > Dashboard'],
        ],
        'absensi' => [
            'index' => ['sidebar' => 'Riwayat Absensi', 'title' => 'Riwayat Kehadiran', 'breadcrumb' => 'Akademik > Riwayat Absensi'],
        ],
        'spp' => [
            'index' => ['sidebar' => 'Tagihan SPP', 'title' => 'Tagihan Pembayaran SPP', 'breadcrumb' => 'Keuangan > Tagihan SPP'],
        ],
        'jadwal' => [
            'index' => ['sidebar' => 'Jadwal', 'title' => 'Jadwal Pelajaran', 'breadcrumb' => 'Akademik > Jadwal'],
        ],
    ],
];
