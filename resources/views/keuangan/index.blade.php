<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/20 ring-1 ring-emerald-400/30">
                <svg class="h-5 w-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 2c4.41 0 8 3.59 8 8s-3.59 8-8 8-8-3.59-8-8 3.59-8 8-8zm-1 13h2v-2h-2v2zm0-4h2V7h-2v6z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Keuangan</h1>
                <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Kelola pemasukan dan pengeluaran</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Alert --}}
        @if (session('success'))
            <div class="alert-success flex items-center gap-2">
                <svg class="h-4 w-4 flex-shrink-0 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error flex items-center gap-2">
                <svg class="h-4 w-4 flex-shrink-0 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- ═══ Statistik ═══ --}}
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <div class="stat-card">
                <div class="stat-icon bg-emerald-500/20">
                    <svg class="h-5 w-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <p class="stat-label">Pemasukan</p>
                <p class="stat-value text-emerald-300">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                <p class="stat-sub">{{ number_format($countPemasukan) }} transaksi</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-rose-500/20">
                    <svg class="h-5 w-5 text-rose-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="stat-label">Pengeluaran</p>
                <p class="stat-value text-rose-300">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                <p class="stat-sub">{{ number_format($countPengeluaran) }} transaksi</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon {{ $saldo >= 0 ? 'bg-blue-500/20' : 'bg-red-500/20' }}">
                    <svg class="h-5 w-5 {{ $saldo >= 0 ? 'text-blue-300' : 'text-red-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <p class="stat-label">Saldo</p>
                <p class="stat-value {{ $saldo >= 0 ? 'text-blue-300' : 'text-red-300' }}">Rp {{ number_format(abs($saldo), 0, ',', '.') }}</p>
                <p class="stat-sub">{{ $saldo >= 0 ? 'Positif' : 'Defisit' }}</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-slate-50 dark:bg-white/10">
                    <svg class="h-5 w-5 text-slate-900 dark:text-slate-600 dark:text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                    </svg>
                </div>
                <p class="stat-label">Total Transaksi</p>
                <p class="stat-value text-slate-900 dark:text-white">{{ number_format($totalTransaksi) }}</p>
                <p class="stat-sub">{{ $totalTransaksi > 0 ? 'Terakhir: ' . $keuangans->first()?->tanggal?->format('d M') : '-' }}</p>
            </div>
        </div>

        {{-- ═══ Action ═══ --}}
        <div class="flex items-center justify-between rounded-2xl border border-slate-300 dark:border-white/20 bg-white/[0.06] p-5 shadow-lg backdrop-blur-md">
            <div class="section-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Daftar Transaksi
            </div>
            <a href="{{ route('keuangan.create') }}"
               class="btn-primary text-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Transaksi
            </a>
        </div>

        {{-- ═══ Filter ═══ --}}
        <div class="content-card">
            <div class="section-title mb-3">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                </svg>
                Filter Transaksi
            </div>
            <form method="GET" action="{{ route('keuangan.index') }}" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="form-label block mb-1">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @foreach ($bulanOptions as $val => $label)
                            <option value="{{ $val }}" {{ request('bulan') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label block mb-1">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="form-label block mb-1">Jenis</label>
                    <select name="jenis" class="form-select">
                        <option value="">Semua</option>
                        <option value="pemasukan" {{ request('jenis') === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="pengeluaran" {{ request('jenis') === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>
                <button type="submit" class="btn-secondary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    Filter
                </button>
                @if (request()->anyFilled(['bulan', 'tahun', 'jenis']))
                    <a href="{{ route('keuangan.index') }}" class="btn-secondary text-xs">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- ═══ Tabel ═══ --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Siswa</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keuangans as $k)
                        <tr>
                            <td class="text-slate-900 dark:text-slate-700 dark:text-white/80">{{ $k->tanggal->format('d M Y') }}</td>
                            <td>
                                @if ($k->jenis === 'pemasukan')
                                    <span class="status-capsule status-capsule-lunas">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                        </svg>
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="status-capsule status-capsule-tunggakan">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>
                            <td class="text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $k->kategori ?? '-' }}</td>
                            <td class="max-w-xs truncate text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $k->keterangan ?? '-' }}</td>
                            <td class="text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $k->siswa?->nama_lengkap ?? '-' }}</td>
                            <td class="text-right font-medium {{ $k->jenis === 'pemasukan' ? 'text-emerald-200' : 'text-rose-200' }}">
                                <span class="{{ $k->jenis === 'pemasukan' ? '' : '' }}">
                                    {{ $k->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('keuangan.edit', $k) }}"
                                       class="rounded-lg border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-3 py-1.5 text-xs font-medium text-slate-900 dark:text-slate-700 dark:text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                                        Edit
                                    </a>
                                    <form action="{{ route('keuangan.destroy', $k) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus transaksi ini?')">
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
                            <td colspan="7">
                                <div class="flex flex-col items-center justify-center py-12">
                                    <svg class="mb-3 h-12 w-12 text-slate-900 dark:text-slate-400 dark:text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 2c4.41 0 8 3.59 8 8s-3.59 8-8 8-8-3.59-8-8 3.59-8 8-8zm-1 13h2v-2h-2v2zm0-4h2V7h-2v6z" />
                                    </svg>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-400 dark:text-white/40">Belum ada data transaksi</p>
                                    <a href="{{ route('keuangan.create') }}" class="mt-2 text-xs text-cyan-300 underline underline-offset-2 hover:text-cyan-200">
                                        Tambah transaksi sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ═══ Pagination ═══ --}}
        <div class="pagination-wrap">
            <p class="pagination-info">
                Menampilkan {{ $keuangans->firstItem() ?? 0 }} - {{ $keuangans->lastItem() ?? 0 }} dari {{ $keuangans->total() }} transaksi
            </p>
            <div class="text-slate-900 dark:text-slate-500 dark:text-white/60">
                {{ $keuangans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
