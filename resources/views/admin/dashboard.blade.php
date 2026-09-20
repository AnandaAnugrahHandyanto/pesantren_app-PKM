<x-app-layout>

    <div class="space-y-6 py-6">
        {{-- Section 1 — Primary Statistics --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach([
                ['title' => 'Total Siswa', 'value' => $totalSiswa, 'color' => 'blue', 'icon' => 'M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z'],
                ['title' => 'Total Guru', 'value' => $totalGuru, 'color' => 'purple', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                ['title' => 'Total Mapel', 'value' => $totalMapel, 'color' => 'emerald', 'icon' => 'M12 6.252v13m0-13C17.443 5.476 21 7.18 21 9.062v10.158c0 1.882-3.557 3.586-9 3.586-5.443 0-9-1.704-9-3.586V9.062c0-1.882 3.557-3.586 9-3.586z'],
                ['title' => 'Jadwal Hari Ini', 'value' => $totalJadwal, 'color' => 'cyan', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z']
            ] as $stat)
            <div class="rounded-2xl border border-slate-300 dark:border-white/10 bg-white dark:bg-white/5 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $stat['title'] }}</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">{{ $stat['value'] }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-{{ $stat['color'] }}-500/20 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Section 2 — Operational Summary --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            {{-- Absensi Hari Ini --}}
            <div class="rounded-2xl border border-slate-300 dark:border-white/10 bg-white dark:bg-white/5 p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Absensi Hari Ini</h2>
                <div class="mt-4 space-y-3">
                    @php $totalAbsen = array_sum($absensi); @endphp
                    @foreach(['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alfa' => 'Alfa'] as $key => $label)
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-600 dark:text-slate-400">{{ $label }}</span>
                            <span class="font-semibold text-slate-900 dark:text-white">{{ $absensi[$key] }}</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-slate-200 dark:bg-white/10">
                            <div class="h-2 rounded-full {{ ['hadir' => 'bg-emerald-500', 'izin' => 'bg-amber-500', 'sakit' => 'bg-blue-500', 'alfa' => 'bg-red-500'][$key] }}"
                                 style="width: {{ $totalAbsen > 0 ? ($absensi[$key] / $totalAbsen * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Ringkasan SPP --}}
            <div class="rounded-2xl border border-slate-300 dark:border-white/10 bg-white dark:bg-white/5 p-5 shadow-sm flex flex-col justify-center">
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white mb-2">Tagihan Menunggak</h2>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $sppTunggakan }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Tagihan Belum Lunas</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $totalSppBills }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Total Tagihan</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3 — Quick Actions --}}
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">Quick Actions</p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach([
                    ['title' => 'Input Absensi', 'route' => 'absensi.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'color' => 'emerald'],
                    ['title' => 'Data Siswa', 'route' => 'siswa.index', 'icon' => 'M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z', 'color' => 'blue'],
                    ['title' => 'Tambah Siswa', 'route' => 'siswa.create', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', 'color' => 'cyan'],
                    ['title' => 'Laporan', 'route' => 'laporan.absensi', 'icon' => 'M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18', 'color' => 'indigo']
                ] as $action)
                <a href="{{ route($action['route']) }}" class="flex items-center gap-4 rounded-xl border border-slate-300 dark:border-white/10 bg-white dark:bg-white/5 p-4 transition hover:bg-slate-50 dark:hover:bg-white/10">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-{{ $action['color'] }}-500/20 text-{{ $action['color'] }}-600 dark:text-{{ $action['color'] }}-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $action['title'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Section 4 — Recent Activity --}}
        <div class="rounded-2xl border border-slate-300 dark:border-white/10 bg-white dark:bg-white/5 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-white/10 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Data Siswa Terbaru</h2>
                <a href="{{ route('siswa.index') }}" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-white/10">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Kelas</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                        @forelse ($latestSiswa as $siswa)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5">
                                <td class="px-5 py-3 text-sm font-medium text-slate-900 dark:text-white">{{ $siswa->nama_lengkap }}</td>
                                <td class="px-5 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $siswa->kelas }}</td>
                                <td class="px-5 py-3 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-5 py-8 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data siswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>