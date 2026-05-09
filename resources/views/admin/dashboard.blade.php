<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Dashboard Admin</h1>
    </x-slot>

    <div class="space-y-6">

        {{-- ===== Statistik Pesantren ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-white/40">Statistik Pesantren</p>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                {{-- Total Santri --}}
                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/60">Total Santri</p>
                            <p class="mt-2 text-4xl font-bold text-white">{{ $totalSantri }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500/30 text-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Santri Laki-laki --}}
                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/60">Santri Laki-laki</p>
                            <p class="mt-2 text-4xl font-bold text-cyan-300">{{ $santriLaki }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-500/30 text-cyan-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Santri Perempuan --}}
                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/60">Santri Perempuan</p>
                            <p class="mt-2 text-4xl font-bold text-pink-300">{{ $santriPerempuan }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-500/30 text-pink-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Guru --}}
                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/60">Total Guru</p>
                            <p class="mt-2 text-4xl font-bold text-purple-300">{{ $totalGuru }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-500/30 text-purple-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Rekap Absensi Hari Ini ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-white/40">Rekap Absensi Hari Ini</p>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                {{-- Hadir --}}
                <div class="rounded-2xl border border-emerald-300/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition duration-200 hover:shadow-[0_0_24px_rgba(16,185,129,0.25)]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/60">Hadir</p>
                            <p class="mt-2 text-4xl font-bold text-green-300">{{ $hadir }}</p>
                        </div>
                        <div title="Hadir - Sukses/Valid" class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-500/30 text-green-300 ring-1 ring-green-300/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Izin --}}
                <div class="rounded-2xl border border-amber-300/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition duration-200 hover:shadow-[0_0_24px_rgba(245,158,11,0.25)]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/60">Izin</p>
                            <p class="mt-2 text-4xl font-bold text-yellow-300">{{ $izin }}</p>
                        </div>
                        <div title="Izin - Menunggu/Persetujuan" class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/30 text-amber-300 ring-1 ring-amber-300/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Sakit --}}
                <div class="rounded-2xl border border-rose-300/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition duration-200 hover:shadow-[0_0_24px_rgba(244,63,94,0.25)]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/60">Sakit</p>
                            <p class="mt-2 text-4xl font-bold text-rose-300">{{ $sakit }}</p>
                        </div>
                        <div title="Sakit - Kondisi Kesehatan" class="flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-500/30 text-rose-300 ring-1 ring-rose-300/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Alfa --}}
                <div class="rounded-2xl border border-red-400/25 bg-white/10 p-5 shadow-lg backdrop-blur-md transition duration-200 hover:shadow-[0_0_24px_rgba(185,28,28,0.25)]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/60">Alfa</p>
                            <p class="mt-2 text-4xl font-bold text-red-200">{{ $alfa }}</p>
                        </div>
                        <div title="Alfa - Tidak Hadir Tanpa Keterangan" class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-700/40 text-red-200 ring-1 ring-red-400/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Menu Navigasi ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-white/40">Menu</p>
            <div class="mb-4">
                <a href="{{ route('absensi.index', ['tanggal' => now()->toDateString()]) }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-amber-300/40 bg-amber-500/20 px-4 py-2 text-sm font-semibold text-amber-100 transition hover:bg-amber-500/30">
                    Edit Absensi Hari Ini
                </a>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                {{-- Data Santri --}}
                <a href="{{ route('santri.index') }}"
                   class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-blue-500/30 text-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">Data Santri</p>
                        <p class="text-sm text-white/60">Kelola data santri</p>
                    </div>
                </a>

                {{-- Tambah Santri --}}
                <a href="{{ route('santri.create') }}"
                   class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-cyan-500/30 text-cyan-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">Tambah Santri</p>
                        <p class="text-sm text-white/60">Daftarkan santri baru</p>
                    </div>
                </a>

                {{-- Absensi --}}
                <a href="{{ route('absensi.index') }}"
                   class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-green-500/30 text-green-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">Absensi</p>
                        <p class="text-sm text-white/60">Lihat data absensi</p>
                    </div>
                </a>

                {{-- Laporan Absensi --}}
                <a href="{{ route('laporan.absensi') }}"
                   class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-indigo-500/30 text-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">Laporan Absensi</p>
                        <p class="text-sm text-white/60">Rekapitulasi absensi</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- ===== Data Santri Terbaru ===== --}}
        <div class="rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            <div class="flex items-center justify-between border-b border-white/20 px-5 py-4">
                <h2 class="text-base font-semibold text-white">Data Santri Terbaru</h2>
                <a href="{{ route('santri.index') }}" class="text-sm font-medium text-indigo-300 hover:text-indigo-200">
                    Lihat semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kelas</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($latestSantri as $santri)
                            <tr class="transition hover:bg-white/10">
                                <td class="px-5 py-3 text-sm font-medium text-white">{{ $santri->nama_lengkap }}</td>
                                <td class="px-5 py-3 text-sm text-white/70">{{ $santri->kelas }}</td>
                                <td class="px-5 py-3 text-sm text-white/70">
                                    {{ $santri->jenis_kelamin === 'L' ? 'Laki-laki' : ($santri->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-sm text-white/40">Belum ada data santri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
