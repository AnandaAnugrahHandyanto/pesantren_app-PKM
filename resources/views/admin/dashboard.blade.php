<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Dashboard Admin</h1>
    </x-slot>

    <div class="space-y-6">
        {{-- Stats --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                <p class="text-sm text-white/60">Total Santri</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $totalSantri }}</p>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                <p class="text-sm text-white/60">Hadir Hari Ini</p>
                <p class="mt-2 text-3xl font-bold text-green-300">{{ $hadir }}</p>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                <p class="text-sm text-white/60">Izin Hari Ini</p>
                <p class="mt-2 text-3xl font-bold text-yellow-300">{{ $izin }}</p>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                <p class="text-sm text-white/60">Alfa Hari Ini</p>
                <p class="mt-2 text-3xl font-bold text-red-300">{{ $alfa }}</p>
            </div>
        </div>

        {{-- Menu --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <a href="{{ route('santri.index') }}"
               class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/30 text-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-semibold text-white">Data Santri</p>
                    <p class="text-sm text-white/60">Kelola data santri pesantren</p>
                </div>
            </a>

            <a href="{{ route('absensi.index') }}"
               class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/30 text-green-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-semibold text-white">Absensi</p>
                    <p class="text-sm text-white/60">Kelola absensi santri</p>
                </div>
            </a>
        </div>

        {{-- Latest Santri --}}
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
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">NIS</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kelas</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kamar</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($latestSantri as $santri)
                            <tr class="transition hover:bg-white/10">
                                <td class="px-5 py-3 text-sm text-white/70">{{ $santri->nis }}</td>
                                <td class="px-5 py-3 text-sm font-medium text-white">{{ $santri->nama }}</td>
                                <td class="px-5 py-3 text-sm text-white/70">{{ $santri->kelas }}</td>
                                <td class="px-5 py-3 text-sm text-white/70">{{ $santri->kamar }}</td>
                                <td class="px-5 py-3 text-sm text-white/70">
                                    {{ $santri->jenis_kelamin === 'L' ? 'Laki-laki' : ($santri->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-sm text-white/40">Belum ada data santri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
