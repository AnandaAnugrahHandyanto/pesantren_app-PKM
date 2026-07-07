<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Data Siswa</h1>
    </x-slot>

    <div class="mx-auto space-y-4 max-w-7xl">

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

        {{-- Toolbar: action buttons --}}
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-white/20 bg-white/10 px-4 py-3 shadow-lg backdrop-blur-md sm:px-5 sm:py-3">
            <p class="text-xs font-semibold uppercase tracking-widest text-white/40">Daftar Siswa</p>
            <div class="flex flex-col gap-2 sm:flex-row">
                <a href="{{ route('siswa.import.form') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-emerald-400/40 bg-emerald-500/20 px-4 py-2 text-sm font-medium text-emerald-200 backdrop-blur-sm transition hover:bg-emerald-500/30 hover:text-white">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Import
                </a>
                <a href="{{ route('siswa.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Siswa
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-white/15 bg-white/10">
                        <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-white/70">NIS</th>
                        <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Nama Lengkap</th>
                        <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Kelas</th>
                        <th class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Jenis Kelamin</th>
                        <th class="px-4 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-white/70">Aksi</th>
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
                            <td colspan="5" class="px-4 py-16 text-center text-sm text-white/40">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="h-12 w-12 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    <span>Belum ada data siswa.</span>
                                    <a href="{{ route('siswa.create') }}" class="text-xs text-indigo-300 hover:text-indigo-200 underline underline-offset-2">
                                        Tambah siswa sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-right text-xs text-white/40">
            Total: {{ $siswas->count() }} siswa
        </div>
    </div>
</x-app-layout>
