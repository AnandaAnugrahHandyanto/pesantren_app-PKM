<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Rekap Absensi Semester</h1>
    </x-slot>

    <div class="space-y-6">

        {{-- Filter Form --}}
        <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur-md">
            <form method="GET" action="{{ route('rekap.absensi') }}"
                  class="flex flex-wrap items-end gap-3">

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Tahun Ajaran</label>
                    <select name="tahun_ajaran"
                            class="rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        @foreach ($tahunAjaranList as $year)
                            <option value="{{ $year }}"
                                    {{ $year === $tahunAjaran ? 'selected' : '' }}
                                    class="bg-indigo-950 text-white">
                                {{ $year }}/{{ $year + 1 }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Semester</label>
                    <select name="semester"
                            class="rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="1" {{ $semester === 1 ? 'selected' : '' }} class="bg-indigo-950 text-white">
                            Semester 1 (Juli – Desember)
                        </option>
                        <option value="2" {{ $semester === 2 ? 'selected' : '' }} class="bg-indigo-950 text-white">
                            Semester 2 (Januari – Juni)
                        </option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Kategori</label>
                    <select name="kategori"
                            class="rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="" {{ $kategori === '' ? 'selected' : '' }} class="bg-indigo-950 text-white">Semua Kategori</option>
                        <option value="sekolah"  {{ $kategori === 'sekolah'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Sekolah</option>
                        <option value="halaqoh"  {{ $kategori === 'halaqoh'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Halaqoh</option>
                        <option value="berkebun" {{ $kategori === 'berkebun' ? 'selected' : '' }} class="bg-indigo-950 text-white">Berkebun</option>
                        <option value="dirosah"  {{ $kategori === 'dirosah'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Dirosah</option>
                    </select>
                </div>

                <button type="submit"
                        class="rounded-xl bg-indigo-500/80 px-5 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-indigo-400/80">
                    Tampilkan
                </button>

                <a href="{{ route('rekap.absensi.cetak', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran, 'kategori' => $kategori]) }}"
                   target="_blank"
                   class="ml-auto inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Rekap
                </a>
            </form>
        </div>

        {{-- Info Periode --}}
        <p class="text-sm text-white/60">
            Menampilkan rekap semester <span class="font-semibold text-white">{{ $semester }}</span>
            tahun ajaran <span class="font-semibold text-white">{{ $tahunAjaran }}/{{ $tahunAjaran + 1 }}</span>
            &mdash;
            periode <span class="font-semibold text-white">
                {{ \Carbon\Carbon::parse($from)->translatedFormat('d F Y') }}
                –
                {{ \Carbon\Carbon::parse($to)->translatedFormat('d F Y') }}
            </span>
        </p>

        {{-- Rekap Table --}}
        <div class="overflow-x-auto rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama Santri</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kelas</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-green-300">
                            <span title="Hadir - Sukses/Valid" class="inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Hadir
                            </span>
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-amber-300">
                            <span title="Izin - Menunggu/Persetujuan" class="inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Izin
                            </span>
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-rose-300">
                            <span title="Sakit - Kondisi Kesehatan" class="inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Sakit
                            </span>
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-red-300">
                            <span title="Alfa - Tidak Hadir Tanpa Keterangan" class="inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Alfa
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($rekap as $i => $santri)
                        <tr class="transition hover:bg-white/[0.04]">
                            <td class="px-4 py-3 text-sm text-white/50">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-white">{{ $santri->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $santri->kelas }}</td>
                            <td class="px-4 py-3 text-center">
                                <span title="Total Hadir" class="inline-flex min-w-[2.8rem] items-center justify-center gap-1 rounded-lg border border-emerald-300/30 bg-emerald-500/20 px-2 py-0.5 text-sm font-semibold text-emerald-100 transition duration-200 hover:shadow-[0_0_16px_rgba(16,185,129,0.28)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $santri->hadir }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span title="Total Izin" class="inline-flex min-w-[2.8rem] items-center justify-center gap-1 rounded-lg border border-amber-300/30 bg-amber-500/20 px-2 py-0.5 text-sm font-semibold text-amber-100 transition duration-200 hover:shadow-[0_0_16px_rgba(245,158,11,0.28)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ $santri->izin }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span title="Total Sakit" class="inline-flex min-w-[2.8rem] items-center justify-center gap-1 rounded-lg border border-rose-300/30 bg-rose-500/20 px-2 py-0.5 text-sm font-semibold text-rose-100 transition duration-200 hover:shadow-[0_0_16px_rgba(244,63,94,0.28)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    {{ $santri->sakit }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span title="Total Alfa" class="inline-flex min-w-[2.8rem] items-center justify-center gap-1 rounded-lg border border-red-400/30 bg-red-700/25 px-2 py-0.5 text-sm font-semibold text-red-100 transition duration-200 hover:shadow-[0_0_16px_rgba(185,28,28,0.28)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $santri->alfa }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-white/40">
                                Tidak ada data santri.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- <div>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-300 hover:text-indigo-200">
                &larr; Kembali ke Dashboard
            </a>
        </div> --}}

    </div>
</x-app-layout>
