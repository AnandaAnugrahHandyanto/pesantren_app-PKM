<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Absensi Harian</h1>
    </x-slot>

    <div class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <form method="GET" action="{{ route('absensi.index') }}" class="flex items-center gap-2">
                <label class="text-sm font-medium text-white/80">Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                    class="rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                <button type="submit"
                    class="rounded-xl bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-white/20">
                    Tampilkan
                </button>
            </form>

            <a href="{{ route('absensi.create') }}"
                class="rounded-xl bg-indigo-500/80 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-indigo-400/80">
                Input Absensi
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-400/30 bg-green-500/20 px-4 py-3 text-sm text-green-200 backdrop-blur-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($absensis as $i => $absensi)
                        <tr class="transition hover:bg-white/10">
                            <td class="px-4 py-3 text-sm text-white/70">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $absensi->santri->nis }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-white">{{ $absensi->santri->nama }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $colors = [
                                        'hadir' => 'bg-green-500/30 text-green-200',
                                        'izin'  => 'bg-yellow-500/30 text-yellow-200',
                                        'alfa'  => 'bg-red-500/30 text-red-200',
                                    ];
                                @endphp
                                <span class="rounded-lg px-2 py-1 text-xs font-semibold {{ $colors[$absensi->status] ?? 'bg-white/10 text-white/70' }}">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('absensi.edit', $absensi) }}"
                                        class="rounded-lg bg-yellow-500/80 px-3 py-1 text-xs font-medium text-white transition hover:bg-yellow-400/80">
                                        Edit
                                    </a>
                                    <form action="{{ route('absensi.destroy', $absensi) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus absensi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg bg-red-500/80 px-3 py-1 text-xs font-medium text-white transition hover:bg-red-400/80">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-white/40">
                                Belum ada data absensi untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
