<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Dashboard Guru</h1>
    </x-slot>

    <div class="space-y-6">
        {{-- Stats --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            {{-- Hadir --}}
            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-white/60">Hadir Hari Ini</p>
                        <p class="mt-2 text-4xl font-bold text-green-300">{{ $hadir }}</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-500/30 text-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Izin --}}
            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-white/60">Izin Hari Ini</p>
                        <p class="mt-2 text-4xl font-bold text-yellow-300">{{ $izin }}</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-yellow-500/30 text-yellow-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Alfa --}}
            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-white/60">Alfa Hari Ini</p>
                        <p class="mt-2 text-4xl font-bold text-red-300">{{ $alfa }}</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-500/30 text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Menu --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
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

            <a href="{{ route('laporan.absensi') }}"
               class="flex items-center gap-4 rounded-2xl border border-white/20 bg-white/10 p-5 shadow-lg backdrop-blur-md transition hover:bg-white/20">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/30 text-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18"/>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-semibold text-white">Laporan Absensi</p>
                    <p class="text-sm text-white/60">Lihat laporan absensi santri</p>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
