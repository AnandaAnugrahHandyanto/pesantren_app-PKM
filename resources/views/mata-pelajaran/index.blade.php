<x-app-layout>

    <div class="space-y-6">
        {{-- Success/Error --}}
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-3 text-sm text-emerald-200 shadow-lg backdrop-blur-md">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-3 text-sm text-red-200 shadow-lg backdrop-blur-md">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header Actions --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-900 dark:text-slate-500 dark:text-white/60">Kelola daftar mata pelajaran per kelas.</p>
            <a href="{{ route('mata-pelajaran.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-500/90 to-blue-600/90 px-4 py-2 text-sm font-semibold text-slate-900 dark:text-white shadow-lg shadow-indigo-500/20 transition hover:from-indigo-400 hover:to-blue-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Mata Pelajaran
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-white/5">
                        <th class="w-12 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">MAPEL</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Guru Pengajar</th>
                        <th class="w-32 px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($mataPelajarans as $i => $mp)
                        <tr class="transition hover:bg-white/[0.04]">
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-slate-500 dark:text-white/50">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">{{ $mp->nama }}</td>
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $mp->guru->nama_lengkap ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('mata-pelajaran.edit', $mp) }}"
                                       class="rounded-lg border border-slate-300 dark:border-white/20 px-3 py-1.5 text-xs font-medium text-slate-900 dark:text-slate-600 dark:text-white/70 transition hover:bg-slate-50 dark:bg-white/10 hover:text-slate-900 dark:text-white">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('mata-pelajaran.destroy', $mp) }}"
                                          onsubmit="return confirm('Hapus mata pelajaran {{ $mp->nama }} untuk kelas {{ $mp->kelas }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg border border-red-500/30 px-3 py-1.5 text-xs font-medium text-red-300 transition hover:bg-red-500/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-sm text-slate-900 dark:text-slate-400 dark:text-white/40">
                                Belum ada mata pelajaran. <a href="{{ route('mata-pelajaran.create') }}" class="text-indigo-300 underline hover:text-indigo-200">Tambah sekarang</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
