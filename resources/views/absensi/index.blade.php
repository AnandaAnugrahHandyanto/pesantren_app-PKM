<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Absensi Harian</h1>
    </x-slot>

    <div class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <form method="GET" action="{{ route('absensi.index') }}" class="flex items-center gap-2">
                <label class="text-sm font-medium text-slate-600">Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                    class="rounded-md border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <button type="submit"
                    class="rounded-md bg-slate-600 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    Tampilkan
                </button>
            </form>

            <a href="{{ route('absensi.create') }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Input Absensi
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($absensis as $i => $absensi)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $absensi->santri->nis }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $absensi->santri->nama }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $colors = [
                                        'hadir' => 'bg-green-100 text-green-700',
                                        'izin' => 'bg-yellow-100 text-yellow-700',
                                        'alfa' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="rounded px-2 py-1 text-xs font-semibold {{ $colors[$absensi->status] ?? '' }}">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('absensi.edit', $absensi) }}"
                                        class="rounded-md bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('absensi.destroy', $absensi) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus absensi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-md bg-red-500 px-3 py-1 text-xs font-medium text-white hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                                Belum ada data absensi untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
