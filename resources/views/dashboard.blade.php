<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Dashboard</h1>
    </x-slot>

    <div class="space-y-6">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wider text-white/50">Total Siswa</p>
                <p class="mt-1 text-3xl font-bold text-white">{{ $totalSiswa }}</p>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wider text-white/50">Hadir Hari Ini</p>
                <p class="mt-1 text-3xl font-bold text-emerald-300">{{ $hadir }}</p>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wider text-white/50">Sakit</p>
                <p class="mt-1 text-3xl font-bold text-rose-300">{{ $sakit }}</p>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wider text-white/50">Izin / Alfa</p>
                <p class="mt-1 text-3xl font-bold text-amber-300">{{ $izin + $alfa }}</p>
            </div>
        </div>

        {{-- Recent Students --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-white/40">Siswa Terdaftar</p>
            <div class="overflow-x-auto rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">NIS</th>
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama</th>
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kelas</th>
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($latestSiswa as $siswa)
                            <tr class="transition hover:bg-white/[0.04]">
                                <td class="whitespace-nowrap px-5 py-3 font-mono text-xs text-white/60">{{ $siswa->nis ?? '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-3 font-medium text-white">{{ $siswa->nama_lengkap }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-white/70">{{ $siswa->kelas }}</td>
                                <td class="whitespace-nowrap px-5 py-3">
                                    @if (($siswa->jenis_kelamin ?? '') === 'L')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-cyan-400/30 bg-cyan-500/20 px-3 py-1 text-xs font-semibold text-cyan-200 shadow-sm">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="5" r="3.5"/><path d="M12 8.5v10M8 14h8"/>
                                            </svg>
                                            Laki-laki
                                        </span>
                                    @elseif (($siswa->jenis_kelamin ?? '') === 'P')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-pink-400/30 bg-pink-500/20 px-3 py-1 text-xs font-semibold text-pink-200 shadow-sm">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="5" r="3.5"/><path d="M12 8.5v6M8 11h8"/>
                                            </svg>
                                            Perempuan
                                        </span>
                                    @else
                                        <span class="text-white/50">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-sm text-white/40">Belum ada siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2 text-right text-xs text-white/40">
                Menampilkan {{ $siswas->count() }} siswa
            </div>
        </div>
    </div>
</x-app-layout>
