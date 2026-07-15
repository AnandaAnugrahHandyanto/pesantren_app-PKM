<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500/20 ring-1 ring-amber-400/30">
                <svg class="h-5 w-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Data Guru</h1>
                <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Kelola data guru dan akun login</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Global Success Toaster --}}
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: '{{ session('success') }}',
                        background: '#0f172a',
                        color: '#fff',
                        iconColor: '#34d399'
                    });
                });
            </script>
        @endif

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-slate-300 dark:border-white/20 bg-white/[0.06] p-5 shadow-lg backdrop-blur-md">
            <div class="section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                Daftar Guru
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <a href="{{ route('guru.create') }}"
                   class="btn-primary text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Guru
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>No HP</th>
                        <th>Akun</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gurus as $guru)
                        <tr>
                            <td class="font-mono text-xs text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $guru->nip ?? '-' }}</td>
                            <td class="font-medium text-slate-900 dark:text-white">{{ $guru->nama_lengkap }}</td>
                            <td class="text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $guru->email ?? '-' }}</td>
                            <td class="font-mono text-xs text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $guru->user?->username ?? '-' }}</td>
                            <td class="text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $guru->no_hp ?? '-' }}</td>
                            <td>
                                @if($guru->user)
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-400/30 bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-red-400/30 bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-700 dark:text-red-200">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('guru.edit', $guru) }}"
                                       class="rounded-lg border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-3 py-1.5 text-xs font-medium text-slate-900 dark:text-slate-700 dark:text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                                        Edit
                                    </a>
                                    <form action="{{ route('guru.destroy', $guru) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus data {{ $guru->nama_lengkap }} dan akun loginnya?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg border border-red-400/30 bg-red-500/10 px-3 py-1.5 text-xs font-medium text-red-700 dark:text-red-200 backdrop-blur-sm transition hover:bg-red-500/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="flex flex-col items-center justify-center py-12">
                                    <svg class="mb-3 h-12 w-12 text-slate-900 dark:text-slate-400 dark:text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-400 dark:text-white/40">Belum ada data guru</p>
                                    <a href="{{ route('guru.create') }}" class="mt-2 text-xs text-cyan-300 underline underline-offset-2 hover:text-cyan-200">
                                        Tambah guru sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            <p class="pagination-info">
                Total: {{ $gurus->total() }} guru
            </p>
            <div class="text-slate-900 dark:text-slate-500 dark:text-white/60">
                {{ $gurus->links() }}
            </div>
        </div>
    </div>
</x-app-layout>