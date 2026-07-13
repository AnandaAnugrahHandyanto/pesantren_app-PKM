<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-500/20 ring-1 ring-cyan-400/30">
                <svg class="h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-white">Data Siswa</h1>
                <p class="text-xs text-white/50">Kelola data siswa dan akun login mereka</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Alerts --}}
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
            @if (session('new_siswa_nis'))
                <div class="alert-success flex items-center gap-2">
                    <div class="ml-3 flex gap-3 text-xs">
                        <span><span class="font-semibold">NIS:</span> {{ session('new_siswa_nis') }}</span>
                        @if (session('new_siswa_password'))
                            <span><span class="font-semibold">Password:</span> <code class="rounded bg-white/10 px-1 py-0.5 font-mono">{{ session('new_siswa_password') }}</code></span>
                        @endif
                    </div>
                </div>
            @endif
        @endif

        @if (session('error'))
            <div class="alert-error flex items-center gap-2">
                <svg class="h-4 w-4 flex-shrink-0 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Filter Section --}}
        <div class="rounded-2xl border border-white/20 bg-white/[0.06] p-5 shadow-lg backdrop-blur-md">
            <div class="section-title mb-4">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
                Filter
            </div>
            <form method="GET" action="{{ route('siswa.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-white/70">Tingkat</label>
                    <select name="tingkat"
                            class="form-select min-w-[130px]">
                        <option value="" {{ !request('tingkat') ? 'selected' : '' }} class="bg-indigo-950 text-white">Semua Tingkat</option>
                        @foreach ($tingkatOptions as $t)
                            <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }} class="bg-indigo-950 text-white">Kelas {{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-white/70">Rombel</label>
                    <select name="rombel"
                            class="form-select min-w-[130px]">
                        <option value="" {{ !request('rombel') ? 'selected' : '' }} class="bg-indigo-950 text-white">Semua Rombel</option>
                        @foreach ($rombelOptions as $r)
                            <option value="{{ $r }}" {{ request('rombel') === $r ? 'selected' : '' }} class="bg-indigo-950 text-white">{{ $r }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="btn-primary text-sm">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        Filter
                    </button>
                    @if (request()->anyFilled(['tingkat', 'rombel']))
                        <a href="{{ route('siswa.index') }}" class="btn-secondary text-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-white/20 bg-white/[0.06] p-5 shadow-lg backdrop-blur-md">
            <div class="section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                Daftar Siswa
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <a href="{{ route('siswa.import.form') }}"
                   class="btn-success text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Import
                </a>
                <a href="{{ route('siswa.create') }}"
                   class="btn-primary text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Siswa
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($siswas as $siswa)
                        <tr class="transition hover:bg-white/[0.04]">
                            <td class="font-mono text-xs text-white/60">{{ $siswa->nis ?? '-' }}</td>
                            <td class="font-medium text-white/90">{{ $siswa->nama_lengkap }}</td>
                            <td class="text-white/70">{{ $siswa->kelas }}</td>
                            <td>
                                @if ($siswa->jenis_kelamin === 'L')
                                    <span class="gender-badge-male">
                                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="5" r="3.5"/><path d="M12 8.5v10M8 14h8"/>
                                        </svg>
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="gender-badge-female">
                                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="5" r="3.5"/><path d="M12 8.5v6M8 11h8"/>
                                        </svg>
                                        Perempuan
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('siswa.edit', $siswa) }}"
                                       class="rounded-lg border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                                        Edit
                                    </a>
                                    <form action="{{ route('siswa.destroy', $siswa) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus siswa {{ $siswa->nama_lengkap }}?')">
                                        @csrf @method('DELETE')
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
                            <td colspan="5">
                                <div class="flex flex-col items-center justify-center py-16">
                                    <svg class="mb-3 h-12 w-12 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    <p class="text-sm font-medium text-white/40">Belum ada data siswa</p>
                                    <a href="{{ route('siswa.create') }}" class="mt-2 text-xs text-cyan-300 underline underline-offset-2 hover:text-cyan-200">
                                        Tambah siswa sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            <p class="pagination-info">
                Total: {{ $siswas->total() }} siswa
            </p>
            <div class="text-white/60">
                {{ $siswas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
