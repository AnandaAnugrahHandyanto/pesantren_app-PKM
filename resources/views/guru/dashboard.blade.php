<x-app-layout>

    <div class="space-y-6">

        {{-- ===== Rekap Absensi Hari Ini ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-900 dark:text-slate-400 dark:text-white/40">Rekap Absensi Hari Ini</p>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                {{-- Hadir --}}
                <div class="stat-card stat-card-hadir">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-slate-900 dark:text-white/55">Hadir</p>
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
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-slate-900 dark:text-white/55">Izin</p>
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
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-slate-900 dark:text-white/55">Sakit</p>
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
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-slate-900 dark:text-white/55">Alfa</p>
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
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-900 dark:text-slate-400 dark:text-white/40">Menu Absensi</p>
            <div class="mb-4">
                <a href="{{ route('absensi.index', ['tanggal' => now()->toDateString()]) }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-amber-300/40 bg-amber-500/20 px-4 py-2 text-sm font-semibold text-amber-100 transition hover:bg-amber-500/30">
                    Edit Absensi Hari Ini
                </a>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                {{-- Absensi Pelajaran --}}
                <a href="{{ route('absensi.index', ['tanggal' => now()->toDateString()]) }}"
                   class="flex items-center gap-4 rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-green-500/30 text-green-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-slate-900 dark:text-white">Absensi</p>
                        <p class="text-sm text-slate-900 dark:text-slate-500 dark:text-white/60">Kelola absensi siswa per mata pelajaran</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- ===== Menu Laporan ===== --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-900 dark:text-slate-400 dark:text-white/40">Laporan</p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                {{-- Laporan Absensi --}}
                <a href="{{ route('laporan.absensi') }}"
                   class="flex items-center gap-4 rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-indigo-500/30 text-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-slate-900 dark:text-white">Laporan Absensi</p>
                        <p class="text-sm text-slate-900 dark:text-slate-500 dark:text-white/60">Lihat laporan absensi siswa</p>
                    </div>
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
