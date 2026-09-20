<x-app-layout>

    {{-- Filter Form --}}
    <div class="content-card">
        <form method="GET" action="{{ route('guru.jadwal') }}" class="flex flex-wrap items-center gap-3">
                
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-900 dark:text-slate-500 dark:text-white/50">NAMA GURU:</span>
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
                            <h3 class="text-slate-900 dark:text-slate-700 dark:text-white/80 font-bold uppercase tracking-wider text-sm">{{ ucfirst($hari) }}</h3>
                        </div>
                        
                        <div class="space-y-3">
                            @forelse($grid[$hari] as $entry)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white dark:bg-white/5 rounded-2xl border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:bg-white/10 transition gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col items-center justify-center w-14 h-14 rounded-xl bg-cyan-500/10 text-cyan-300 border border-cyan-500/20 flex-shrink-0">
                                            <span class="text-[10px] font-bold">JAM</span>
                                            <span class="text-xs font-bold">{{ $entry->jam_mulai->format('H:i') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-slate-900 dark:text-white font-semibold">{{ $entry->mataPelajaran->nama ?? '-' }}</p>
                                            <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">{{ $guru->nama_lengkap ?? '-' }}</p>
                                            <span class="inline-block mt-1 text-[10px] bg-slate-50 dark:bg-white/10 px-2 py-0.5 rounded text-slate-900 dark:text-slate-500 dark:text-white/60">Kelas {{ $entry->kelas }}{{ $entry->rombel }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto text-right">
                                        <span class="text-sm font-medium text-slate-900 dark:text-slate-800 dark:text-white/90">
                                            {{ $entry->jam_mulai->format('H:i') }} - {{ $entry->jam_selesai->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 bg-white dark:bg-white/5 rounded-2xl border border-slate-200 dark:border-white/10 text-center">
                                    <p class="text-slate-900 dark:text-white/30 text-xs italic">Tidak ada jadwal</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-10 text-center rounded-2xl border border-dashed border-slate-200 dark:border-white/10 bg-white dark:bg-white/5">
                <p class="text-slate-900 dark:text-slate-500 dark:text-white/50 text-sm">Silakan pilih guru untuk menampilkan jadwal mengajar.</p>
            </div>
        @endif
    </div>
</x-app-layout>
