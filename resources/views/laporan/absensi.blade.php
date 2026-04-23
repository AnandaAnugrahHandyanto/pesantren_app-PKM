<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Absensi
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter Tanggal --}}
            <form method="GET" action="{{ route('laporan.absensi') }}"
                  class="bg-white rounded-lg shadow p-4 mb-6 flex flex-wrap items-center gap-3">
                <label class="text-sm font-medium text-gray-700">Pilih Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                       class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                    Tampilkan
                </button>
                <span class="ml-auto text-sm text-gray-500">
                    Tanggal: <span class="font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </span>
                </span>
            </form>

            {{-- Ringkasan --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <p class="text-xs font-semibold text-green-600 uppercase tracking-wide">Hadir</p>
                    <p class="text-3xl font-bold text-green-700 mt-1">{{ $ringkasan['hadir'] }}</p>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                    <p class="text-xs font-semibold text-yellow-600 uppercase tracking-wide">Izin</p>
                    <p class="text-3xl font-bold text-yellow-700 mt-1">{{ $ringkasan['izin'] }}</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                    <p class="text-xs font-semibold text-red-600 uppercase tracking-wide">Alfa</p>
                    <p class="text-3xl font-bold text-red-700 mt-1">{{ $ringkasan['alfa'] }}</p>
                </div>
            </div>

            {{-- Tabel Laporan --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIS</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Santri</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($absensis as $i => $absensi)
                            @php
                                $badge = [
                                    'hadir' => 'bg-green-100 text-green-700',
                                    'izin'  => 'bg-yellow-100 text-yellow-700',
                                    'alfa'  => 'bg-red-100 text-red-700',
                                ][$absensi->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $absensi->santri->nis }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $absensi->santri->nama }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $badge }}">
                                        {{ ucfirst($absensi->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-400">
                                    Tidak ada data absensi untuk tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Link kembali --}}
            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
