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

                <button type="submit"
                        class="rounded-xl bg-indigo-500/80 px-5 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-indigo-400/80">
                    Tampilkan
                </button>

                <a href="{{ route('rekap.absensi.cetak', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran]) }}"
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
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-green-400/80">Hadir</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-yellow-400/80">Izin</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-blue-400/80">Sakit</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-red-400/80">Alfa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($rekap as $i => $santri)
                        <tr class="transition hover:bg-white/[0.04]">
                            <td class="px-4 py-3 text-sm text-white/50">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-white">{{ $santri->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $santri->kelas }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block min-w-[2rem] rounded-lg bg-green-500/20 px-2 py-0.5 text-sm font-semibold text-green-200">
                                    {{ $santri->hadir }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block min-w-[2rem] rounded-lg bg-yellow-500/20 px-2 py-0.5 text-sm font-semibold text-yellow-200">
                                    {{ $santri->izin }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block min-w-[2rem] rounded-lg bg-blue-500/20 px-2 py-0.5 text-sm font-semibold text-blue-200">
                                    {{ $santri->sakit }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block min-w-[2rem] rounded-lg bg-red-500/20 px-2 py-0.5 text-sm font-semibold text-red-200">
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

        <div>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-300 hover:text-indigo-200">
                &larr; Kembali ke Dashboard
            </a>
        </div>

    </div>
</x-app-layout>
