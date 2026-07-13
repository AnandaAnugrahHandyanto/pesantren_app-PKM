<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-500/20 ring-1 ring-cyan-400/30">
                <svg class="h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-white">Jadwal Mengajar</h1>
                <p class="text-xs text-white/50">Guru: {{ $guru->nama_lengkap ?? '-' }}</p>
            </div>
        </div>
    </x-slot>

    {{-- Filter Form --}}
    <div class="content-card">
        <form method="GET" action="{{ route('guru.jadwal') }}" class="flex flex-wrap items-center gap-3">
                
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-white/50">NAMA GURU:</span>
                <select name="guru_id" onchange="this.form.submit()" class="form-select w-auto min-w-[200px]">
                    @foreach($guruList as $g)
                        <option value="{{ $g->id }}" {{ $guruId == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <noscript>
                <button type="submit" class="btn-secondary text-xs">Tampilkan</button>
            </noscript>
        </form>
    </div>

        {{-- Schedule Grid --}}
        @if($guruId)
            <div class="space-y-8">
                @foreach($hariList as $hari)
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-6 w-1 rounded-full bg-cyan-500"></div>
                            <h3 class="text-white/80 font-bold uppercase tracking-wider text-sm">{{ ucfirst($hari) }}</h3>
                        </div>
                        
                        <div class="space-y-3">
                            @forelse($grid[$hari] as $entry)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col items-center justify-center w-14 h-14 rounded-xl bg-cyan-500/10 text-cyan-300 border border-cyan-500/20 flex-shrink-0">
                                            <span class="text-[10px] font-bold">JAM</span>
                                            <span class="text-xs font-bold">{{ $entry->jam_mulai->format('H:i') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ $entry->mataPelajaran->nama ?? '-' }}</p>
                                            <p class="text-xs text-white/50">{{ $guru->nama_lengkap ?? '-' }}</p>
                                            <span class="inline-block mt-1 text-[10px] bg-white/10 px-2 py-0.5 rounded text-white/60">Kelas {{ $entry->kelas }}{{ $entry->rombel }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto text-right">
                                        <span class="text-sm font-medium text-white/90">
                                            {{ $entry->jam_mulai->format('H:i') }} - {{ $entry->jam_selesai->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 bg-white/5 rounded-2xl border border-white/10 text-center">
                                    <p class="text-white/30 text-xs italic">Tidak ada jadwal</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-10 text-center rounded-2xl border border-dashed border-white/10 bg-white/5">
                <p class="text-white/50 text-sm">Silakan pilih guru untuk menampilkan jadwal mengajar.</p>
            </div>
        @endif
    </div>
</x-app-layout>
