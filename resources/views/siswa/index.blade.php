<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold">Data Siswa</h1>
            <div class="flex gap-2">
                <a href="{{ route('siswa.import.form') }}"
                    class="rounded-lg border border-emerald-400/40 bg-emerald-500/20 px-4 py-2 text-sm font-medium text-emerald-200 backdrop-blur-sm transition hover:bg-emerald-500/30 hover:text-white">
                    Import
                </a>
                <a href="{{ route('siswa.create') }}"
                    class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                    + Tambah Siswa
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl">

        @if (session('success'))
            <div class="mb-4 rounded-xl border border-green-400/30 bg-green-500/20 px-4 py-3 text-sm text-green-200 backdrop-blur-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-red-400/30 bg-red-500/20 px-4 py-3 text-sm text-red-200 backdrop-blur-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-white/70">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($siswas as $siswa)
                        <tr class="transition hover:bg-white/[0.04]">
                            <td class="whitespace-nowrap px-4 py-3 font-mono text-xs text-white/60">{{ $siswa->nis ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-white/90">{{ $siswa->nama_lengkap }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-white/70">{{ $siswa->kelas }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if ($siswa->jenis_kelamin === 'L')
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-cyan-400/30 bg-cyan-500/20 px-3 py-1 text-xs font-semibold text-cyan-200 shadow-sm">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="5" r="3.5"/>
                                            <path d="M12 8.5v10M8 14h8"/>
                                        </svg>
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-pink-400/30 bg-pink-500/20 px-3 py-1 text-xs font-semibold text-pink-200 shadow-sm">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="5" r="3.5"/>
                                            <path d="M12 8.5v6M8 11h8"/>
                                        </svg>
                                        Perempuan
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('siswa.edit', $siswa) }}"
                                        class="rounded-lg border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                                        Edit
                                    </a>
                                    <form action="{{ route('siswa.destroy', $siswa) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa {{ $siswa->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg border border-red-400/30 bg-red-500/20 px-3 py-1.5 text-xs font-medium text-red-200 backdrop-blur-sm transition hover:bg-red-500/30 hover:text-white">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-white/40">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-right text-xs text-white/40">
            Total: {{ $siswas->count() }} siswa
        </div>
    </div>
</x-app-layout>
