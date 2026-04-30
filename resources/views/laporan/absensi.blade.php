<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Laporan Absensi</h1>
    </x-slot>

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
        <div class="grid grid-cols-3 gap-4">
            <div class="rounded-2xl border border-green-400/30 bg-green-500/20 p-4 text-center shadow-lg backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wide text-green-300">Hadir</p>
                <p class="mt-1 text-3xl font-bold text-green-200">{{ $ringkasan['hadir'] }}</p>
            </div>
            <div class="rounded-2xl border border-yellow-400/30 bg-yellow-500/20 p-4 text-center shadow-lg backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wide text-yellow-300">Izin</p>
                <p class="mt-1 text-3xl font-bold text-yellow-200">{{ $ringkasan['izin'] }}</p>
            </div>
            <div class="rounded-2xl border border-red-400/30 bg-red-500/20 p-4 text-center shadow-lg backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wide text-red-300">Alfa</p>
                <p class="mt-1 text-3xl font-bold text-red-200">{{ $ringkasan['alfa'] }}</p>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        <div class="overflow-x-auto rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama Santri</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($absensis as $i => $absensi)
                        @php
                            $badge = [
                                'hadir' => 'bg-green-500/30 text-green-200',
                                'izin'  => 'bg-yellow-500/30 text-yellow-200',
                                'sakit' => 'bg-blue-500/30 text-blue-200',
                                'alfa'  => 'bg-red-500/30 text-red-200',
                            ][$absensi->status] ?? 'bg-white/10 text-white/70';
                        @endphp
                        <tr class="transition hover:bg-white/10">
                            <td class="px-4 py-3 text-sm text-white/70">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $absensi->santri->nis }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-white">{{ $absensi->santri->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ ucfirst($absensi->kategori) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="rounded-lg px-2 py-1 text-xs font-semibold {{ $badge }}">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-white/40">
                                Tidak ada data absensi untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Link kembali --}}
        <div>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-300 hover:text-indigo-200">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
