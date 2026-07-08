<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="text-xl font-semibold leading-tight text-white">📅 Jadwal Pelajaran</h2>
                <form method="GET" class="flex items-center gap-2">
                    <select name="kelas" onchange="this.form.submit()"
                            class="rounded-xl border-white/20 bg-white/10 px-3 py-1.5 text-sm text-white">
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <a href="{{ route('jadwal.create', ['kelas' => $kelas]) }}"
               class="rounded-xl bg-cyan-500/20 px-4 py-2 text-sm font-medium text-cyan-200 ring-1 ring-cyan-400/30 transition hover:bg-cyan-500/30">
                + Tambah Jadwal
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Grid Jadwal --}}
            <div class="overflow-x-auto rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-xs uppercase tracking-wider text-white/50">
                            <th class="w-24 px-3 py-3 font-medium">Jam</th>
                            @foreach(['senin','selasa','rabu','kamis','jumat','sabtu'] as $hari)
                                <th class="px-3 py-3 font-medium text-center">{{ ucfirst($hari) }}</th>
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
                                        $entry = $grid[$hari]->first(function($j) use ($mulai, $selesai) {
                                            return $j->jam_mulai->format('H:i') === $mulai;
                                        });
                                    @endphp
                                    <td class="px-3 py-2 text-center align-middle">
                                        @if($entry)
                                            <div class="rounded-xl bg-cyan-500/10 p-2 ring-1 ring-cyan-400/20">
                                                <p class="text-xs font-medium text-cyan-200">{{ $entry->mataPelajaran->nama ?? '-' }}</p>
                                                <p class="text-[10px] text-white/50">{{ $entry->guru->nama_lengkap ?? '-' }}</p>
                                                <div class="mt-1 flex justify-center gap-1">
                                                    <a href="{{ route('jadwal.edit', $entry) }}" class="text-[10px] text-indigo-300 hover:text-indigo-200">✏️</a>
                                                    <form action="{{ route('jadwal.destroy', $entry) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                                                        @csrf @method('DELETE')
                                                        <button class="text-[10px] text-red-300 hover:text-red-200">🗑️</button>
                                                    </form>
                                                </div>
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
