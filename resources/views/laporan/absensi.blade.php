<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Laporan Absensi</h1>
    </x-slot>

    @php
        $statusMeta = [
            'hadir' => [
                'label' => 'Hadir',
                'tooltip' => 'Hadir - Sukses/Valid',
                'ringkasanClass' => 'border-emerald-400/30 bg-emerald-500/20 text-emerald-200',
                'badgeClass' => 'border-emerald-300/50 bg-emerald-500/25 text-emerald-100',
            ],
            'izin' => [
                'label' => 'Izin',
                'tooltip' => 'Izin - Menunggu/Persetujuan',
                'ringkasanClass' => 'border-amber-400/30 bg-amber-500/20 text-amber-200',
                'badgeClass' => 'border-amber-300/50 bg-amber-500/25 text-amber-100',
            ],
            'sakit' => [
                'label' => 'Sakit',
                'tooltip' => 'Sakit - Kondisi Kesehatan',
                'ringkasanClass' => 'border-rose-400/30 bg-rose-500/20 text-rose-200',
                'badgeClass' => 'border-rose-300/50 bg-rose-500/25 text-rose-100',
            ],
            'alfa' => [
                'label' => 'Alfa',
                'tooltip' => 'Alfa - Tidak Hadir Tanpa Keterangan',
                'ringkasanClass' => 'border-red-500/35 bg-red-700/25 text-red-100',
                'badgeClass' => 'border-red-400/50 bg-red-700/30 text-red-100',
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
                <div class="rounded-2xl border p-4 shadow-lg backdrop-blur-md transition duration-200 hover:shadow-[0_0_20px_rgba(255,255,255,0.16)] {{ $statusMeta[$status]['ringkasanClass'] }}">
                    <div class="flex items-center justify-center gap-1.5 text-xs font-semibold uppercase tracking-wide" title="{{ $statusMeta[$status]['tooltip'] }}">
                        @switch($status)
                            @case('hadir')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @break

                            @case('izin')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @break

                            @case('sakit')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            @break

                            @default
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                        @endswitch
                        <span>{{ $statusMeta[$status]['label'] }}</span>
                    </div>
                    <p class="mt-1 text-center text-3xl font-bold">{{ $ringkasan[$status] }}</p>
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
                                    class="inline-flex items-center gap-1.5 rounded-lg border px-2.5 py-1 text-xs font-semibold transition duration-200 hover:-translate-y-[1px] hover:shadow-md {{ $meta['badgeClass'] ?? 'border-white/20 bg-white/10 text-white/70' }}">
                                    @if ($absensi->status === 'hadir')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @elseif ($absensi->status === 'izin')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    @elseif ($absensi->status === 'sakit')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    @elseif ($absensi->status === 'alfa')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
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
