<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Rekap Absensi Semester</h1>
    </x-slot>

    <div class="space-y-6">

        {{-- Filter Form --}}
        <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur-md">
            <form method="GET" action="{{ route('rekap.absensi') }}"
                  class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-end">

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Tahun Ajaran</label>
                    <select name="tahun_ajaran"
                            class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
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
                            class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="1" {{ $semester === 1 ? 'selected' : '' }} class="bg-indigo-950 text-white">
                            Ganjil (Juli – Desember)
                        </option>
                        <option value="2" {{ $semester === 2 ? 'selected' : '' }} class="bg-indigo-950 text-white">
                            Genap (Januari – Juni)
                        </option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id"
                            class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="" {{ $mataPelajaranId === '' || $mataPelajaranId === null ? 'selected' : '' }} class="bg-indigo-950 text-white">Semua Mata Pelajaran</option>
                        @foreach ($mataPelajaranOptions as $mp)
                            <option value="{{ $mp->id }}" {{ (int) $mataPelajaranId === $mp->id ? 'selected' : '' }} class="bg-indigo-950 text-white">
                                {{ $mp->nama }} (Kelas {{ $mp->kelas }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Pilih Kelas</label>
                    <select name="kelas"
                            class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="" class="bg-indigo-950 text-white">Semua Kelas</option>
                        @foreach ($kelasOptions as $k)
                            <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }} class="bg-indigo-950 text-white">Kelas {{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2 sm:items-end">
                    <button type="submit"
                            class="flex-1 rounded-xl bg-indigo-500/80 px-5 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-indigo-400/80 sm:flex-none">
                        Tampilkan
                    </button>

                    <a href="{{ route('rekap.absensi.cetak', ['semester' => $semester, 'tahun_ajaran' => $tahunAjaran, 'mata_pelajaran_id' => $mataPelajaranId, 'kelas' => request('kelas')]) }}"
                       target="_blank"
                       class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20 sm:flex-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak Rekap
                    </a>
                </div>
            </form>
        </div>

        {{-- Info & Table --}}
        @if (request()->hasAny(['tahun_ajaran', 'semester', 'mata_pelajaran_id', 'kelas']))
        <p class="text-sm text-white/60">
            Menampilkan rekap semester <span class="font-semibold text-white">{{ $semesterLabel }}</span>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama Siswa</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kelas</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-green-300">
                            <span title="Hadir - Sukses/Valid" class="inline-flex items-center gap-1">
                                <x-status-icon status="hadir" class="h-3.5 w-3.5" />
                                Hadir
                            </span>
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-amber-300">
                            <span title="Izin - Menunggu/Persetujuan" class="inline-flex items-center gap-1">
                                <x-status-icon status="izin" class="h-3.5 w-3.5" />
                                Izin
                            </span>
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-rose-300">
                            <span title="Sakit - Kondisi Kesehatan" class="inline-flex items-center gap-1">
                                <x-status-icon status="sakit" class="h-3.5 w-3.5" />
                                Sakit
                            </span>
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-red-300">
                            <span title="Alfa - Tidak Hadir Tanpa Keterangan" class="inline-flex items-center gap-1">
                                <x-status-icon status="alfa" class="h-3.5 w-3.5" />
                                Alfa
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($rekap as $i => $siswa)
                        <tr class="transition hover:bg-white/[0.04]">
                            <td class="px-4 py-3 text-sm text-white/50">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-white">{{ $siswa->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $siswa->kelas }}</td>
                            <td class="px-4 py-3 text-center">
                                <span title="Total Hadir" class="status-capsule status-capsule-hadir min-w-[3rem] justify-center px-2.5 py-1 text-sm">
                                    <x-status-icon status="hadir" class="h-3 w-3" />
                                    {{ $siswa->hadir }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span title="Total Izin" class="status-capsule status-capsule-izin min-w-[3rem] justify-center px-2.5 py-1 text-sm">
                                    <x-status-icon status="izin" class="h-3 w-3" />
                                    {{ $siswa->izin }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span title="Total Sakit" class="status-capsule status-capsule-sakit min-w-[3rem] justify-center px-2.5 py-1 text-sm">
                                    <x-status-icon status="sakit" class="h-3 w-3" />
                                    {{ $siswa->sakit }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span title="Total Alfa" class="status-capsule status-capsule-alfa min-w-[3rem] justify-center px-2.5 py-1 text-sm">
                                    <x-status-icon status="alfa" class="h-3 w-3" />
                                    {{ $siswa->alfa }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-white/40">
                                Tidak ada data siswa untuk kriteria yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif

    </div>
</x-app-layout>