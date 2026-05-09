<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Dashboard Admin</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Santri</p>
                <p class="mt-2 text-3xl font-bold text-slate-800">{{ $totalSantri }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Hadir Hari Ini</p>
                <div class="mt-2 flex items-center justify-between">
                    <p class="text-3xl font-bold text-green-600">{{ $hadir }}</p>
                    <span title="Hadir - Sukses/Valid" class="rounded-full bg-emerald-100 p-2 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Izin Hari Ini</p>
                <div class="mt-2 flex items-center justify-between">
                    <p class="text-3xl font-bold text-amber-600">{{ $izin }}</p>
                    <span title="Izin - Menunggu/Persetujuan" class="rounded-full bg-amber-100 p-2 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Sakit Hari Ini</p>
                <div class="mt-2 flex items-center justify-between">
                    <p class="text-3xl font-bold text-rose-600">{{ $sakit }}</p>
                    <span title="Sakit - Kondisi Kesehatan" class="rounded-full bg-rose-100 p-2 text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Alfa Hari Ini</p>
                <div class="mt-2 flex items-center justify-between">
                    <p class="text-3xl font-bold text-red-700">{{ $alfa }}</p>
                    <span title="Alfa - Tidak Hadir Tanpa Keterangan" class="rounded-full bg-red-100 p-2 text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-800">Data Santri Terbaru</h2>
                @if (Auth::user()->role === 'admin')
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
                                <td class="px-5 py-3 text-sm font-medium text-slate-800">{{ $santri->nama_lengkap }}</td>
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
