<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-semibold leading-tight text-white">
                <svg class="mr-2 inline-block h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                Jadwal Pelajaran
            </h2>
            <span class="rounded-full bg-cyan-500/20 px-3 py-1 text-xs font-medium text-cyan-200 ring-1 ring-cyan-400/30">
                Kelas {{ $kelasSiswa }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl px-4 sm:px-6 lg:px-8">
            {{-- List Jadwal --}}
            @php $hariList = ['senin','selasa','rabu','kamis','jumat','sabtu']; @endphp
            <div class="space-y-10">
                @foreach($hariList as $hari)
                    @if($grid[$hari]->isNotEmpty())
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-8 w-1.5 rounded-full bg-cyan-400"></div>
                            <h3 class="text-white/90 font-bold uppercase tracking-widest text-lg">{{ ucfirst($hari) }}</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($grid[$hari] as $entry)
                                <div class="relative overflow-hidden p-5 bg-white/5 rounded-3xl border border-white/10 hover:border-cyan-500/50 transition-all duration-300 hover:shadow-[0_0_20px_rgba(6,182,212,0.15)] group">
                                    <div class="flex items-start gap-4">
                                        <div class="flex flex-col items-center justify-center w-16 h-16 rounded-2xl bg-cyan-500/10 text-cyan-300 border border-cyan-500/20 flex-shrink-0">
                                            <span class="text-[10px] font-bold opacity-70">JAM</span>
                                            <span class="text-sm font-bold">{{ $entry->jam_mulai->format('H:i') }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-white text-lg font-bold leading-tight mb-1">{{ $entry->mataPelajaran->nama ?? '-' }}</p>
                                            <p class="text-sm text-cyan-300/70 font-medium">{{ $entry->guru->nama_lengkap ?? '-' }}</p>
                                            <div class="mt-3 flex items-center gap-2 text-[11px] text-white/40">
                                                <span class="bg-white/5 px-2 py-1 rounded-md">{{ $entry->jam_mulai->format('H:i') }} - {{ $entry->jam_selesai->format('H:i') }}</span>
                                                <span class="bg-cyan-900/30 text-cyan-300 px-2 py-1 rounded-md border border-cyan-500/20">{{ $entry->jam_mulai->diffInMinutes($entry->jam_selesai) }} mnt</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>