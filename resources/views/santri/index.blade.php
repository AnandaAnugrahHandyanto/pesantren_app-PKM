<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Data Santri</h1>
    </x-slot>

    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Kelola data santri pesantren.</p>
            <a href="{{ route('santri.create') }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Tambah Santri
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
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kamar</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($santris as $santri)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $santri->nis }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-slate-800">{{ $santri->nama }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $santri->kelas }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $santri->kamar }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $santri->jenis_kelamin === 'L' ? 'Laki-laki' : ($santri->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('santri.edit', $santri) }}"
                                        class="rounded-md bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('santri.destroy', $santri) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                                Belum ada data santri.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
