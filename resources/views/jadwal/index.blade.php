<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-500/20 ring-1 ring-cyan-400/30">
                <svg class="h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-white">Jadwal Pelajaran</h1>
                <p class="text-xs text-white/50">Kelola jadwal pelajaran per kelas</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Success Alert --}}
        @if (session('success'))
            <div class="alert-success flex items-center gap-2">
                <svg class="h-4 w-4 flex-shrink-0 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ═══ Statistik ═══ --}}
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <div class="stat-card">
                <div class="stat-icon bg-white/10">
                    <svg class="h-5 w-5 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <p class="stat-label">Kelas</p>
                <p class="stat-value text-white">{{ $kelas }}</p>
                <p class="stat-sub">Jadwal aktif</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-cyan-500/20">
                    <svg class="h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <p class="stat-label">Total Jadwal</p>
                <p class="stat-value text-cyan-300">{{ $totalJadwal }}</p>
                <p class="stat-sub">Sesi pelajaran</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-indigo-500/20">
                    <svg class="h-5 w-5 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <p class="stat-label">Mata Pelajaran</p>
                <p class="stat-value text-indigo-300">{{ $totalMapel }}</p>
                <p class="stat-sub">Unik di kelas ini</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-amber-500/20">
                    <svg class="h-5 w-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <p class="stat-label">Guru</p>
                <p class="stat-value text-amber-300">{{ $totalGuru }}</p>
                <p class="stat-sub">Pengajar di kelas ini</p>
            </div>
        </div>

        {{-- ═══ Filter & Action ═══ --}}
        <div class="content-card">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="section-title">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    Pilih Kelas
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form method="GET" action="{{ route('jadwal.index') }}" class="flex items-center gap-2">
                        <select name="kelas" onchange="this.form.submit()"
                                class="form-select w-auto min-w-[120px]">
                            @foreach($kelasList as $k)
                                <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        <noscript>
                            <button type="submit" class="btn-secondary text-xs">Tampilkan</button>
                        </noscript>
                    </form>
                    <a href="{{ route('jadwal.create', ['kelas' => $kelas]) }}"
                       class="btn-primary text-sm">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Jadwal
                    </a>
                </div>
            </div>
        </div>

        {{-- ═══ Grid Jadwal ═══ --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th class="w-28">Jam</th>
                        @foreach(['senin','selasa','rabu','kamis','jumat','sabtu'] as $hari)
                            <th class="text-center">{{ ucfirst($hari) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $jamSlots = [
                            ['07:00', '07:45'], ['07:45', '08:30'], ['08:30', '09:15'],
                            ['09:15', '09:45'], ['09:45', '10:30'], ['10:30', '11:15'],
                            ['11:15', '12:00'], ['12:00', '12:45'], ['12:45', '13:30'],
                        ];
                        $hariList = ['senin','selasa','rabu','kamis','jumat','sabtu'];
                    @endphp

                    @forelse($jamSlots as $slot)
                        @php [$mulai, $selesai] = $slot; @endphp
                        <tr class="border-b border-white/[0.04] transition hover:bg-white/[0.02]">
                            <td class="whitespace-nowrap px-4 py-2 text-[0.65rem] font-semibold uppercase tracking-wide text-white/40">
                                {{ $mulai }}
                            </td>
                            @foreach($hariList as $hari)
                                @php
                                    $entry = $grid[$hari]->first(function($j) use ($mulai) {
                                        return $j->jam_mulai->format('H:i') === $mulai;
                                    });
                                @endphp
                                <td class="px-2 py-1.5 text-center align-middle">
                                    @if($entry)
                                        <div class="group relative mx-auto max-w-[140px] rounded-xl bg-gradient-to-br from-cyan-500/10 to-blue-500/5 p-2.5 ring-1 ring-cyan-400/20 transition-all duration-200 hover:from-cyan-500/15 hover:to-blue-500/10 hover:ring-cyan-400/30">
                                            <p class="truncate text-xs font-semibold text-cyan-200">{{ $entry->mataPelajaran->nama ?? '-' }}</p>
                                            <p class="truncate text-[10px] text-white/50">{{ $entry->guru->nama_lengkap ?? '-' }}</p>
                                            <p class="text-[10px] text-white/30">{{ substr($entry->jam_mulai, 0, 5) }} - {{ substr($entry->jam_selesai, 0, 5) }}</p>
                                            <div class="mt-1.5 flex justify-center gap-1 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                                                <a href="{{ route('jadwal.edit', $entry) }}"
                                                   class="inline-flex items-center justify-center rounded-lg px-1.5 py-1 text-indigo-300 transition hover:bg-indigo-500/20 hover:text-indigo-200"
                                                   title="Edit">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('jadwal.destroy', $entry) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Hapus jadwal {{ $entry->mataPelajaran->nama ?? '' }}?')">
                                                    @csrf @method('DELETE')
                                                    <button class="inline-flex items-center justify-center rounded-lg px-1.5 py-1 text-red-300 transition hover:bg-red-500/20 hover:text-red-200"
                                                            title="Hapus">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-white/15">—</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="flex flex-col items-center justify-center py-12">
                                    <svg class="mb-3 h-12 w-12 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                    <p class="text-sm font-medium text-white/40">Belum ada jadwal untuk kelas {{ $kelas }}</p>
                                    <a href="{{ route('jadwal.create', ['kelas' => $kelas]) }}" class="mt-2 text-xs text-cyan-300 underline underline-offset-2 hover:text-cyan-200">
                                        Tambah jadwal sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
