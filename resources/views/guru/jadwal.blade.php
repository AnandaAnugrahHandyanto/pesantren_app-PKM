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

    <div class="space-y-6">
        {{-- Filter Form --}}
        <div class="content-card">
            <form method="GET" action="{{ route('guru.jadwal') }}" class="flex flex-wrap items-center gap-3">
                <select name="kelas" onchange="this.form.submit()" class="form-select w-auto min-w-[150px]">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                    @endforeach
                </select>
                <noscript>
                    <button type="submit" class="btn-secondary text-xs">Tampilkan</button>
                </noscript>
            </form>
        </div>

        {{-- Schedule Grid --}}
        @if($kelas)
            <div class="space-y-8">
                @foreach($hariList as $hari)
                    @if(count($grid[$hari]) > 0)
                        <div>
                            <h3 class="text-white/80 font-bold uppercase tracking-wider text-sm mb-4 border-l-4 border-cyan-500 pl-3">{{ ucfirst($hari) }}</h3>
                            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($grid[$hari] as $entry)
                                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition">
                                        <p class="text-white font-semibold">{{ $entry->mataPelajaran->nama ?? '-' }}</p>
                                        <p class="text-xs text-white/50 mb-3">Kelas: {{ $entry->kelas }}</p>
                                        <div class="flex items-center justify-between text-xs text-white/70">
                                            <span>{{ $entry->jam_mulai->format('H:i') }} - {{ $entry->jam_selesai->format('H:i') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="p-10 text-center rounded-2xl border border-dashed border-white/10 bg-white/5">
                <p class="text-white/50 text-sm">Silakan pilih kelas untuk menampilkan jadwal mengajar Anda.</p>
            </div>
        @endif
    </div>
</x-app-layout>
