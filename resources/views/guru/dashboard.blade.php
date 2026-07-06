<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Dashboard Guru</h1>
    </x-slot>

    <div class="space-y-6">

        {{-- ===== Rekap Absensi Hari Ini ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-white/40">Rekap Absensi Hari Ini</p>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                {{-- Hadir --}}
                <div class="stat-card stat-card-hadir">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-white/55">Hadir</p>
                            <p class="mt-2 text-4xl font-bold text-emerald-300">{{ $hadir }}</p>
                        </div>
                        <div title="Hadir - Sukses/Valid" class="flex h-16 w-16 items-center justify-center rounded-3xl border border-emerald-300/20 bg-emerald-500/10 text-emerald-300/80 shadow-[0_0_24px_rgba(16,185,129,0.18)]">
                            <x-status-icon status="hadir" class="h-8 w-8" />
                        </div>
                    </div>
                </div>

                {{-- Izin --}}
                <div class="stat-card stat-card-izin">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-white/55">Izin</p>
                            <p class="mt-2 text-4xl font-bold text-amber-300">{{ $izin }}</p>
                        </div>
                        <div title="Izin - Menunggu/Persetujuan" class="flex h-16 w-16 items-center justify-center rounded-3xl border border-amber-300/20 bg-amber-500/10 text-amber-300/80 shadow-[0_0_24px_rgba(245,158,11,0.18)]">
                            <x-status-icon status="izin" class="h-8 w-8" />
                        </div>
                    </div>
                </div>

                {{-- Sakit --}}
                <div class="stat-card stat-card-sakit">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-white/55">Sakit</p>
                            <p class="mt-2 text-4xl font-bold text-rose-300">{{ $sakit }}</p>
                        </div>
                        <div title="Sakit - Kondisi Kesehatan" class="flex h-16 w-16 items-center justify-center rounded-3xl border border-rose-300/20 bg-rose-500/10 text-rose-300/80 shadow-[0_0_24px_rgba(244,63,94,0.18)]">
                            <x-status-icon status="sakit" class="h-8 w-8" />
                        </div>
                    </div>
                </div>

                {{-- Alfa --}}
                <div class="stat-card stat-card-alfa">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-white/55">Alfa</p>
                            <p class="mt-2 text-4xl font-bold text-red-200">{{ $alfa }}</p>
                        </div>
                        <div title="Alfa - Tidak Hadir Tanpa Keterangan" class="flex h-16 w-16 items-center justify-center rounded-3xl border border-red-400/20 bg-red-600/10 text-red-200/80 shadow-[0_0_24px_rgba(185,28,28,0.18)]">
                            <x-status-icon status="alfa" class="h-8 w-8" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Menu Absensi ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-white/40">Menu Absensi</p>
            <div class="mb-4">
                <a href="{{ route('absensi.index', ['tanggal' => now()->toDateString()]) }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-amber-300/40 bg-amber-500/20 px-4 py-2 text-sm font-semibold text-amber-100 transition hover:bg-amber-500/30">
                    Edit Absensi Hari Ini
                </a>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                {{-- Absensi Pelajaran --}}
                <a href="{{ route('absensi.index', ['kategori' => 'pelajaran']) }}"
                   class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-green-500/30 text-green-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">Absensi Pelajaran</p>
                        <p class="text-sm text-white/60">Kelola absensi kegiatan pelajaran</p>
                    </div>
                </a>

                {{-- Absensi Ekstrakurikuler --}}
                <a href="{{ route('absensi.index', ['kategori' => 'ekstrakurikuler']) }}"
                   class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-purple-500/30 text-purple-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">Absensi Ekstrakurikuler</p>
                        <p class="text-sm text-white/60">Kelola absensi kegiatan ekstrakurikuler</p>
                    </div>
                </a>

                {{-- Absensi Upacara --}}
                <a href="{{ route('absensi.index', ['kategori' => 'upacara']) }}"
                   class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-500/30 text-emerald-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">Absensi Upacara</p>
                        <p class="text-sm text-white/60">Kelola absensi kegiatan upacara sekolah</p>
                    </div>
                </a>

                {{-- Absensi Kegiatan Khusus --}}
                <a href="{{ route('absensi.index', ['kategori' => 'kegiatan_khusus']) }}"
                   class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-amber-500/30 text-amber-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">Absensi Kegiatan Khusus</p>
                        <p class="text-sm text-white/60">Kelola absensi kegiatan khusus sekolah</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- ===== Menu Laporan ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-white/40">Laporan</p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
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
                        <p class="text-sm text-white/60">Lihat laporan absensi siswa</p>
                    </div>
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
