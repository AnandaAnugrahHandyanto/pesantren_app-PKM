<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-semibold leading-tight text-white">
                <svg class="mr-2 inline-block h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
                Dashboard Siswa
            </h2>
            <span class="rounded-full bg-cyan-500/20 px-3 py-1 text-xs font-medium text-cyan-200 ring-1 ring-cyan-400/30">
                {{ Auth::user()->siswa->kelasFormatted ?? Auth::user()->siswa->kelas ?? '-' }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-5">
                <div class="stat-card">
                    <p class="stat-label">Total Absensi</p>
                    <p class="stat-value">{{ $stats['total'] }}</p>
                </div>
                <div class="stat-card" style="--stat-bg: rgba(52,211,153,0.08); --stat-border: rgb(52,211,153);">
                    <p class="stat-label text-emerald-300">Hadir</p>
                    <p class="stat-value text-emerald-200">{{ $stats['hadir'] }}</p>
                </div>
                <div class="stat-card" style="--stat-bg: rgba(251,191,36,0.08); --stat-border: rgb(251,191,36);">
                    <p class="stat-label text-amber-300">Izin</p>
                    <p class="stat-value text-amber-200">{{ $stats['izin'] }}</p>
                </div>
                <div class="stat-card" style="--stat-bg: rgba(244,63,94,0.08); --stat-border: rgb(244,63,94);">
                    <p class="stat-label text-rose-300">Sakit</p>
                    <p class="stat-value text-rose-200">{{ $stats['sakit'] }}</p>
                </div>
                <div class="stat-card" style="--stat-bg: rgba(248,113,113,0.08); --stat-border: rgb(248,113,113);">
                    <p class="stat-label text-red-300">Alfa</p>
                    <p class="stat-value text-red-200">{{ $stats['alfa'] }}</p>
                </div>
            </div>

            {{-- SPP Status --}}
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-xl">
                <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white/60">Status SPP Tahun {{ now()->year }}</h3>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div>
                        <p class="text-xs text-white/50">Tagihan</p>
                        <p class="text-lg font-bold text-white">{{ $statSpp['total'] }} bulan</p>
                    </div>
                    <div>
                        <p class="text-xs text-white/50">Lunas</p>
                        <p class="text-lg font-bold text-emerald-300">{{ $statSpp['lunas'] }} bulan</p>
                    </div>
                    <div>
                        <p class="text-xs text-white/50">Belum</p>
                        <p class="text-lg font-bold text-amber-300">{{ $statSpp['total'] - $statSpp['lunas'] }} bulan</p>
                    </div>
                    <div class="flex items-end">
                        @if($statSpp['total'] > 0 && $statSpp['lunas'] < $statSpp['total'])
                            <a href="{{ route('siswa.spp.index') }}"
                               class="rounded-xl bg-cyan-500/20 px-4 py-2 text-xs font-medium text-cyan-200 ring-1 ring-cyan-400/30 transition hover:bg-cyan-500/30">
                                Bayar SPP →
                            </a>
                        @elseif($statSpp['total'] > 0)
                            <span class="rounded-xl bg-emerald-500/20 px-4 py-2 text-xs font-medium text-emerald-200 ring-1 ring-emerald-400/30">
                                <svg class="-ml-0.5 mr-1 inline-block h-3.5 w-3.5 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Lunas semua
                            </span>
                        @else
                            <span class="text-xs text-white/40">Belum ada tagihan</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Riwayat Absensi --}}
            <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-xl">
                <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white/60">Riwayat Absensi (30 terakhir)</h3>

                @if($absensis->isEmpty())
                    <p class="py-8 text-center text-sm text-white/40">Belum ada data absensi.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-white/10 text-xs uppercase tracking-wider text-white/50">
                                    <th class="px-3 py-2 font-medium">Tanggal</th>
                                    <th class="px-3 py-2 font-medium">Mata Pelajaran</th>
                                    <th class="px-3 py-2 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($absensis as $a)
                                <tr class="border-b border-white/5 transition hover:bg-white/5">
                                    <td class="px-3 py-2.5 text-white/80">{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td class="px-3 py-2.5 text-white/80">{{ $a->mataPelajaran->nama ?? '-' }}</td>
                                    <td class="px-3 py-2.5">
                                        <span class="status-capsule status-{{ $a->status }}">
                                            {{ ucfirst($a->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
