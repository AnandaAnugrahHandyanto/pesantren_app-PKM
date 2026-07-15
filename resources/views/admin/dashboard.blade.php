<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Dashboard Admin</h1>
    </x-slot>

    <div class="space-y-6">

        {{-- ===== Statistik Sekolah ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-900 dark:text-slate-400 dark:text-white/40">Statistik Sekolah</p>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                {{-- Total Siswa --}}
                <div class="content-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-900 dark:text-white/60">Total Siswa</p>
                            <p class="mt-2 text-4xl font-bold text-slate-900 dark:text-white">{{ $totalSiswa }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500/30 text-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Siswa Laki-laki --}}
                <div class="content-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-900 dark:text-slate-500 dark:text-white/60">Siswa Laki-laki</p>
                            <p class="mt-2 text-4xl font-bold text-cyan-300">{{ $siswaLaki }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-500/30 text-cyan-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Siswa Perempuan --}}
                <div class="content-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-900 dark:text-slate-500 dark:text-white/60">Siswa Perempuan</p>
                            <p class="mt-2 text-4xl font-bold text-pink-300">{{ $siswaPerempuan }}</p>
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
                <div class="content-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-900 dark:text-slate-500 dark:text-white/60">Total Guru</p>
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

        {{-- ===== Menu Navigasi ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-900 dark:text-slate-400 dark:text-white/40">Menu</p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                {{-- Data Siswa --}}
                <a href="{{ route('siswa.index') }}"
                   class="flex items-center gap-4 content-card transition hover:bg-slate-200 dark:hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-blue-500/30 text-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-slate-900 dark:text-white">Data Siswa</p>
                        <p class="text-sm text-slate-900 dark:text-slate-500 dark:text-white/60">Kelola data siswa</p>
                    </div>
                </a>

                {{-- Tambah Siswa --}}
                <a href="{{ route('siswa.create') }}"
                   class="flex items-center gap-4 content-card transition hover:bg-slate-200 dark:hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-cyan-500/30 text-cyan-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-slate-900 dark:text-white">Tambah Siswa</p>
                        <p class="text-sm text-slate-900 dark:text-slate-500 dark:text-white/60">Daftarkan siswa baru</p>
                    </div>
                </a>

                {{-- Absensi --}}
                <a href="{{ route('absensi.index') }}"
                   class="flex items-center gap-4 content-card transition hover:bg-slate-200 dark:hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-green-500/30 text-green-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-slate-900 dark:text-white">Absensi</p>
                        <p class="text-sm text-slate-900 dark:text-slate-500 dark:text-white/60">Lihat data absensi</p>
                    </div>
                </a>

                {{-- Laporan Absensi --}}
                <a href="{{ route('laporan.absensi') }}"
                   class="flex items-center gap-4 content-card transition hover:bg-slate-200 dark:hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-indigo-500/30 text-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-slate-900 dark:text-white">Laporan Absensi</p>
                        <p class="text-sm text-slate-900 dark:text-slate-500 dark:text-white/60">Rekapitulasi absensi</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- ===== Data Siswa Terbaru ===== --}}
        <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 shadow-lg backdrop-blur-md">
            <div class="flex items-center justify-between border-b border-slate-300 dark:border-white/20 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Data Siswa Terbaru</h2>
                <a href="{{ route('siswa.index') }}" class="text-sm font-medium text-indigo-300 hover:text-indigo-200">
                    Lihat semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-white/5">
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Kelas</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($latestSiswa as $siswa)
                            <tr class="transition hover:bg-slate-50 dark:bg-white/10">
                                <td class="px-5 py-3 text-sm font-medium text-slate-900 dark:text-white">{{ $siswa->nama_lengkap }}</td>
                                <td class="px-5 py-3 text-sm text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $siswa->kelas }}</td>
                                <td class="px-5 py-3 text-sm text-slate-900 dark:text-slate-600 dark:text-white/70">
                                @if(($siswa->jenis_kelamin ?? '') === 'L')
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-cyan-400/30 bg-cyan-500/20 px-3 py-1 text-xs font-semibold text-cyan-200 shadow-sm">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="5" r="3.5"/><path d="M12 8.5v10M8 14h8"/>
                                        </svg>
                                        Laki-laki
                                    </span>
                                @elseif(($siswa->jenis_kelamin ?? '') === 'P')
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-pink-400/30 bg-pink-500/20 px-3 py-1 text-xs font-semibold text-pink-200 shadow-sm">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="5" r="3.5"/><path d="M12 8.5v6M8 11h8"/>
                                        </svg>
                                        Perempuan
                                    </span>
                                @else
                                    <span class="text-slate-900 dark:text-slate-500 dark:text-white/50">-</span>
                                @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-sm text-slate-900 dark:text-slate-400 dark:text-white/40">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>