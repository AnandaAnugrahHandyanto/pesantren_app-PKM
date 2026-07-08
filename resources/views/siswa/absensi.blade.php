<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">📋 Riwayat Absensi</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-x-auto rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-xl">
                @if($absensis->isEmpty())
                    <p class="py-8 text-center text-sm text-white/40">Belum ada data absensi.</p>
                @else
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-xs uppercase tracking-wider text-white/50">
                                <th class="px-3 py-2 font-medium">Tanggal</th>
                                <th class="px-3 py-2 font-medium">Mata Pelajaran</th>
                                <th class="px-3 py-2 font-medium">Status</th>
                                <th class="px-3 py-2 font-medium">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensis as $a)
                            <tr class="border-b border-white/5 transition hover:bg-white/5">
                                <td class="px-3 py-2.5 text-white/80">{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('l, d M Y') }}</td>
                                <td class="px-3 py-2.5 text-white/80">{{ $a->mataPelajaran->nama ?? '-' }}</td>
                                <td class="px-3 py-2.5">
                                    <span class="status-capsule status-{{ $a->status }}">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 text-white/60">{{ $a->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $absensis->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
