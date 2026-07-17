<x-app-layout>

    @php
        $statusMeta = [
            'hadir' => [
                'label' => 'Hadir',
                'tooltip' => 'Hadir - Sukses/Valid',
                'ringkasanClass' => 'stat-card stat-card-hadir',
                'badgeClass' => 'status-capsule status-capsule-hadir',
                'textClass' => 'text-emerald-300',
            ],
            'izin' => [
                'label' => 'Izin',
                'tooltip' => 'Izin - Menunggu/Persetujuan',
                'ringkasanClass' => 'stat-card stat-card-izin',
                'badgeClass' => 'status-capsule status-capsule-izin',
                'textClass' => 'text-amber-300',
            ],
            'sakit' => [
                'label' => 'Sakit',
                'tooltip' => 'Sakit - Kondisi Kesehatan',
                'ringkasanClass' => 'stat-card stat-card-sakit',
                'badgeClass' => 'status-capsule status-capsule-sakit',
                'textClass' => 'text-rose-300',
            ],
            'alfa' => [
                'label' => 'Alfa',
                'tooltip' => 'Alfa - Tidak Hadir Tanpa Keterangan',
                'ringkasanClass' => 'stat-card stat-card-alfa',
                'badgeClass' => 'status-capsule status-capsule-alfa',
                'textClass' => 'text-red-200',
            ],
        ];
    @endphp

    <div class="space-y-6">
        {{-- Filter Tanggal --}}
        <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-4 shadow-lg backdrop-blur-md">
            <form method="GET" action="{{ route('laporan.absensi') }}"
                  class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-end">
                <div class="flex flex-col gap-1 sm:min-w-0">
                    <label class="text-xs font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Pilih Tanggal:</label>
                    <input type="date" name="tanggal" value="{{ $tanggal }}"
                           class="w-full rounded-xl border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id"
                            class="w-full rounded-xl border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="" {{ $mataPelajaranId === '' || $mataPelajaranId === null ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Semua Mata Pelajaran</option>
                        @foreach ($mataPelajaranOptions as $mp)
                            <option value="{{ $mp->id }}" {{ (int) $mataPelajaranId === $mp->id ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">
                                {{ $mp->nama }} (Kelas {{ $mp->kelas }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Pilih Kelas:</label>
                    <select name="kelas"
                            class="w-full rounded-xl border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="" class="bg-indigo-950 text-slate-900 dark:text-white">Semua Kelas</option>
                        @foreach ($kelasOptions as $k)
                            <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Kelas {{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-indigo-500/80 px-4 py-2 text-sm font-medium text-slate-900 dark:text-white backdrop-blur-sm transition hover:bg-indigo-400/80 sm:w-auto">
                    Tampilkan
                </button>
                <span class="text-sm text-slate-900 dark:text-slate-500 dark:text-white/60 sm:ml-auto sm:self-center">
                    Tanggal: <span class="font-semibold text-slate-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </span>
                </span>
            </form>
        </div>

        {{-- Info & Table --}}
        @if (request()->hasAny(['tanggal', 'mata_pelajaran_id', 'kelas']))
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            @foreach (['hadir', 'izin', 'sakit', 'alfa'] as $status)
                <div class="{{ $statusMeta[$status]['ringkasanClass'] }}">
                    <div class="flex items-center justify-between gap-3" title="{{ $statusMeta[$status]['tooltip'] }}">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-900 dark:text-white/55">{{ $statusMeta[$status]['label'] }}</p>
                            <p class="mt-2 text-3xl font-bold {{ $statusMeta[$status]['textClass'] }}">{{ $ringkasan[$status] }}</p>
                        </div>
                        <div @class([
                            'flex h-14 w-14 items-center justify-center rounded-3xl border',
                            'border-emerald-300/20 bg-emerald-500/10 text-emerald-300/80' => $status === 'hadir',
                            'border-amber-300/20 bg-amber-500/10 text-amber-300/80' => $status === 'izin',
                            'border-rose-300/20 bg-rose-500/10 text-rose-300/80' => $status === 'sakit',
                            'border-red-400/20 bg-red-600/10 text-red-200/80' => $status === 'alfa',
                        ])>
                            <x-status-icon :status="$status" class="h-7 w-7" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tabel Laporan --}}
        <div class="overflow-x-auto rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Nama Siswa</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($absensis as $i => $absensi)
                        @php
                            $meta = $statusMeta[$absensi->status] ?? null;
                        @endphp
                        <tr class="transition hover:bg-slate-50 dark:bg-white/10">
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">{{ $absensi->siswa->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $absensi->mataPelajaran->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span title="{{ $meta['tooltip'] ?? ucfirst($absensi->status) }}"
                                    class="{{ $meta['badgeClass'] ?? 'status-capsule border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 text-slate-900 dark:text-slate-600 dark:text-white/70' }}">
                                    <x-status-icon :status="$absensi->status" class="h-3.5 w-3.5" />
                                    {{ $meta['label'] ?? ucfirst($absensi->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-900 dark:text-slate-400 dark:text-white/40">
                                Tidak ada data absensi untuk kriteria yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif

        {{-- Link kembali --}}
        {{-- <div>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-300 hover:text-indigo-200">
                &larr; Kembali ke Dashboard
            </a>
        </div> --}}
    </div>
</x-app-layout>
