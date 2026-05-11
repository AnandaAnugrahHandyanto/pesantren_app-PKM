<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Laporan Absensi</h1>
    </x-slot>

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
        <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur-md">
            <form method="GET" action="{{ route('laporan.absensi') }}"
                  class="flex flex-wrap items-center gap-3">
                <label class="text-sm font-medium text-white/80">Pilih Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                       class="rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">

                <select name="kategori"
                        class="rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                    <option value="" {{ $kategori === '' ? 'selected' : '' }} class="bg-indigo-950 text-white">Semua Kategori</option>
                    <option value="sekolah"  {{ $kategori === 'sekolah'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Sekolah</option>
                    <option value="halaqoh"  {{ $kategori === 'halaqoh'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Halaqoh</option>
                    <option value="berkebun" {{ $kategori === 'berkebun' ? 'selected' : '' }} class="bg-indigo-950 text-white">Berkebun</option>
                    <option value="dirosah"  {{ $kategori === 'dirosah'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Dirosah</option>
                </select>

                <button type="submit"
                        class="rounded-xl bg-indigo-500/80 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-indigo-400/80">
                    Tampilkan
                </button>
                <span class="ml-auto text-sm text-white/60">
                    Tanggal: <span class="font-semibold text-white">
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </span>
                </span>
            </form>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            @foreach (['hadir', 'izin', 'sakit', 'alfa'] as $status)
                <div class="{{ $statusMeta[$status]['ringkasanClass'] }}">
                    <div class="flex items-center justify-between gap-3" title="{{ $statusMeta[$status]['tooltip'] }}">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-white/55">{{ $statusMeta[$status]['label'] }}</p>
                            <p class="mt-2 text-3xl font-bold {{ $statusMeta[$status]['textClass'] }}">{{ $ringkasan[$status] }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-3xl border border-white/10 bg-white/5 text-white/30">
                            <x-status-icon :status="$status" class="h-7 w-7" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tabel Laporan --}}
        <div class="overflow-x-auto rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama Santri</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($absensis as $i => $absensi)
                        @php
                            $meta = $statusMeta[$absensi->status] ?? null;
                        @endphp
                        <tr class="transition hover:bg-white/10">
                            <td class="px-4 py-3 text-sm text-white/70">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-white">{{ $absensi->santri->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ ucfirst($absensi->kategori) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span title="{{ $meta['tooltip'] ?? ucfirst($absensi->status) }}"
                                    class="{{ $meta['badgeClass'] ?? 'status-capsule border-white/20 bg-white/10 text-white/70' }}">
                                    <x-status-icon :status="$absensi->status" class="h-3.5 w-3.5" />
                                    {{ $meta['label'] ?? ucfirst($absensi->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-white/40">
                                Tidak ada data absensi untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Link kembali --}}
        {{-- <div>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-300 hover:text-indigo-200">
                &larr; Kembali ke Dashboard
            </a>
        </div> --}}
    </div>
</x-app-layout>
