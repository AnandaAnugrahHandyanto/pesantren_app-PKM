<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-lg font-semibold">Daftar Guru</h1>
            <a href="{{ route('guru.create') }}"
                class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                + Tambah Guru
            </a>
        </div>
    </x-slot>

    <div class="rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-400/30 bg-emerald-500/20 px-4 py-3 text-sm text-emerald-200 backdrop-blur-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="border-b border-white/20">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-white/55">NIP</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-white/55">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-white/55">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-white/55">No HP</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-white/55">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-white/55">Tgl Masuk</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.18em] text-white/55">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($gurus as $guru)
                        <tr class="transition hover:bg-white/5">
                            <td class="px-4 py-3 text-sm text-white">{{ $guru->nip }}</td>
                            <td class="px-4 py-3 text-sm text-white font-medium">{{ $guru->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $guru->email }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $guru->no_hp ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                    @if($guru->jenis_kelamin === 'L')
                                        bg-cyan-500/20 text-cyan-200 border border-cyan-400/30
                                    @else
                                        bg-pink-500/20 text-pink-200 border border-pink-400/30
                                    @endif">
                                    {{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-white/70">
                                {{ $guru->tanggal_masuk ? \Carbon\Carbon::parse($guru->tanggal_masuk)->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('guru.edit', $guru) }}"
                                        class="rounded-lg border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                                        Edit
                                    </a>
                                    <form action="{{ route('guru.destroy', $guru) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus data guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-lg border border-red-400/30 bg-red-500/20 px-3 py-1.5 text-xs font-medium text-red-200 backdrop-blur-sm transition hover:bg-red-500/30">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-white/50">Belum ada data guru</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-4 border-t border-white/20">
            {{ $gurus->links() }}
        </div>
    </div>
</x-app-layout>