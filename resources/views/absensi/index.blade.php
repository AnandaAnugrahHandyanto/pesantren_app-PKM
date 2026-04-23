<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Absensi Harian</h1>
            <a href="{{ route('absensi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Input Absensi
            </a>
        </div>

        {{-- Filter tanggal --}}
        <form method="GET" action="{{ route('absensi.index') }}" class="mb-4 flex items-center gap-2">
            <label class="text-sm font-medium text-gray-700">Tanggal:</label>
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                class="border rounded p-2 text-sm">
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-700">
                Tampilkan
            </button>
        </form>

        @if (session('success'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($absensis as $i => $absensi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $absensi->santri->nis }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $absensi->santri->nama }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $colors = [
                                        'hadir' => 'bg-green-100 text-green-700',
                                        'izin'  => 'bg-yellow-100 text-yellow-700',
                                        'alfa'  => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $colors[$absensi->status] ?? '' }}">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('absensi.edit', $absensi) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('absensi.destroy', $absensi) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus absensi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">
                                Belum ada data absensi untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
