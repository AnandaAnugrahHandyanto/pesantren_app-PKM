<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-semibold leading-tight text-white">📅 Jadwal Pelajaran</h2>
            <span class="rounded-full bg-cyan-500/20 px-3 py-1 text-xs font-medium text-cyan-200 ring-1 ring-cyan-400/30">
                Kelas {{ $kelasSiswa }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-x-auto rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-xs uppercase tracking-wider text-white/50">
                            <th class="w-24 px-3 py-3 font-medium">Jam</th>
                            @foreach(['senin','selasa','rabu','kamis','jumat','sabtu'] as $hari)
                                <th class="px-3 py-3 text-center font-medium">{{ ucfirst($hari) }}</th>
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

                        @foreach($jamSlots as $slot)
                            @php [$mulai, $selesai] = $slot; @endphp
                            <tr class="border-b border-white/5 hover:bg-white/5">
                                <td class="px-3 py-3 text-xs font-medium text-white/50">
                                    {{ $mulai }} - {{ $selesai }}
                                </td>
                                @foreach($hariList as $hari)
                                    @php
                                        $entry = $grid[$hari]->first(function($j) use ($mulai) {
                                            return $j->jam_mulai->format('H:i') === $mulai;
                                        });
                                    @endphp
                                    <td class="px-3 py-2 text-center align-middle">
                                        @if($entry)
                                            <div class="rounded-xl bg-cyan-500/10 p-2 ring-1 ring-cyan-400/20">
                                                <p class="text-xs font-medium text-cyan-200">{{ $entry->mataPelajaran->nama ?? '-' }}</p>
                                                <p class="text-[10px] text-white/50">{{ $entry->guru->nama_lengkap ?? '-' }}</p>
                                            </div>
                                        @else
                                            <span class="text-[10px] text-white/20">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
