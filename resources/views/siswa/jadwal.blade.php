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
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            {{-- List Jadwal --}}
            @php $hariList = ['senin','selasa','rabu','kamis','jumat','sabtu']; @endphp
            <div class="space-y-8">
                @foreach($hariList as $hari)
                    <div>
                        <h3 class="text-white/80 font-bold uppercase tracking-wider text-sm mb-4 border-l-4 border-cyan-500 pl-3">{{ ucfirst($hari) }}</h3>
                        
                        <div class="space-y-3">
                            @forelse($grid[$hari] as $entry)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition group gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex flex-col items-center justify-center w-14 h-14 rounded-xl bg-cyan-500/10 text-cyan-300 border border-cyan-500/20 flex-shrink-0">
                                            <span class="text-[10px] font-bold">JAM</span>
                                            <span class="text-xs font-bold">{{ $entry->jam_mulai->format('H:i') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ $entry->mataPelajaran->nama ?? '-' }}</p>
                                            <p class="text-xs text-white/50">{{ $entry->guru->nama_lengkap ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                        <span class="text-sm font-medium text-white/70 text-left sm:text-right">
                                            <span class="text-white/90 font-bold">{{ $entry->jam_mulai->format('H:i') }} - {{ $entry->jam_selesai->format('H:i') }}</span>
                                            <br>
                                            <span class="text-[11px] text-cyan-300/80 bg-cyan-500/10 px-2 py-0.5 rounded-md">
                                                Durasi: {{ $entry->jam_mulai->diffInMinutes($entry->jam_selesai) }} menit
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-white/20 text-xs italic px-4">Tidak ada jadwal</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>