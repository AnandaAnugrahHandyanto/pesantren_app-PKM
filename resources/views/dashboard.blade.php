<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Dashboard Admin</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Santri</p>
                <p class="mt-2 text-3xl font-bold text-slate-800">{{ $totalSantri }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Hadir Hari Ini</p>
                <p class="mt-2 text-3xl font-bold text-green-600">{{ $hadir }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Izin Hari Ini</p>
                <p class="mt-2 text-3xl font-bold text-yellow-600">{{ $izin }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Alfa Hari Ini</p>
                <p class="mt-2 text-3xl font-bold text-red-600">{{ $alfa }}</p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-800">Data Santri Terbaru</h2>
                @if (Auth::user()?->role === 'admin')
                    <a href="{{ route('santri.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                        Lihat semua
                    </a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">NIS</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kelas</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kamar</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($latestSantri as $santri)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 text-sm text-slate-700">{{ $santri->nis }}</td>
                                <td class="px-5 py-3 text-sm font-medium text-slate-800">{{ $santri->nama }}</td>
                                <td class="px-5 py-3 text-sm text-slate-700">{{ $santri->kelas }}</td>
                                <td class="px-5 py-3 text-sm text-slate-700">{{ $santri->kamar }}</td>
                                <td class="px-5 py-3 text-sm text-slate-700">
                                    {{ $santri->jenis_kelamin === 'L' ? 'Laki-laki' : ($santri->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">Belum ada data santri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
