<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Data Santri</h1>
    </x-slot>

    <div class="space-y-4">
        @if (session('success'))
            <div class="rounded-xl border border-green-400/30 bg-green-500/20 px-4 py-3 text-sm text-green-200 backdrop-blur-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            {{-- Card Header --}}
            <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
                <div>
                    <h2 class="text-base font-semibold text-white">Daftar Santri</h2>
                    <p class="mt-0.5 text-xs text-white/50">Kelola data santri pesantren.</p>
                </div>
                <a href="{{ route('santri.create') }}"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-blue-500/80 px-4 py-2 text-sm font-medium text-white shadow-sm backdrop-blur-sm transition hover:bg-blue-400/80">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Santri
                </a>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">NIS</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Nama</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Kelas</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Kamar</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Jenis Kelamin</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($santris as $santri)
                            <tr class="transition hover:bg-white/[0.07]">
                                <td class="px-5 py-3 text-sm text-white/70">{{ $santri->nis }}</td>
                                <td class="px-5 py-3 text-sm font-medium text-white">{{ $santri->nama }}</td>
                                <td class="px-5 py-3 text-sm text-white/70">{{ $santri->kelas }}</td>
                                <td class="px-5 py-3 text-sm text-white/70">{{ $santri->kamar }}</td>
                                <td class="px-5 py-3 text-sm text-white/70">
                                    {{ $santri->jenis_kelamin === 'L' ? 'Laki-laki' : ($santri->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                </td>
                                <td class="px-5 py-3 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('santri.edit', $santri) }}"
                                            class="rounded-lg bg-yellow-500/80 px-3 py-1.5 text-xs font-medium text-white shadow-sm transition hover:bg-yellow-400/80">
                                            Edit
                                        </a>
                                        <form action="{{ route('santri.destroy', $santri) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-lg bg-red-500/80 px-3 py-1.5 text-xs font-medium text-white shadow-sm transition hover:bg-red-400/80">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-white/40">
                                    Belum ada data santri.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
