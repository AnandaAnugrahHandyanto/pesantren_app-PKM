<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Data Santri</h1>
    </x-slot>

    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <p class="text-sm text-white/60">Kelola data santri pesantren.</p>
            <a href="{{ route('santri.create') }}"
                class="rounded-xl bg-indigo-500/80 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-indigo-400/80">
                Tambah Santri
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
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Kamar</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/50">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($santris as $santri)
                        <tr class="transition hover:bg-white/10">
                            <td class="px-4 py-3 text-sm text-white/70">{{ $santri->nis }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-white">{{ $santri->nama }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $santri->kelas }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $santri->kamar }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">
                                {{ $santri->jenis_kelamin === 'L' ? 'Laki-laki' : ($santri->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('santri.edit', $santri) }}"
                                        class="rounded-lg bg-yellow-500/80 px-3 py-1 text-xs font-medium text-white transition hover:bg-yellow-400/80">
                                        Edit
                                    </a>
                                    <form action="{{ route('santri.destroy', $santri) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                                Belum ada data santri.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
