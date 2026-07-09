<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-500/20 ring-1 ring-cyan-400/30">
                <svg class="h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-white">Manajemen SPP</h1>
                <p class="text-xs text-white/50">Kelola tagihan SPP siswa</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Alert Success --}}
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
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            <div class="stat-card">
                <div class="stat-icon bg-white/10">
                    <svg class="h-5 w-5 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <p class="stat-label">Total Tagihan</p>
                <p class="stat-value text-white">{{ number_format($totalTagihan) }}</p>
                <p class="stat-sub">Rp {{ number_format($totalJumlah, 0, ',', '.') }}</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-emerald-500/20">
                    <svg class="h-5 w-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="stat-label">Lunas</p>
                <p class="stat-value text-emerald-300">{{ number_format($totalLunas) }}</p>
                <p class="stat-sub">Rp {{ number_format($jumlahLunas, 0, ',', '.') }}</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-amber-500/20">
                    <svg class="h-5 w-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="stat-label">Belum Dibayar</p>
                <p class="stat-value text-amber-300">{{ number_format($totalBelum) }}</p>
                <p class="stat-sub">{{ $totalTagihan > 0 ? round(($totalBelum / $totalTagihan) * 100) : 0 }}% dari total</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-red-500/20">
                    <svg class="h-5 w-5 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <p class="stat-label">Tunggakan</p>
                <p class="stat-value text-red-300">{{ number_format($totalTunggakan) }}</p>
                <p class="stat-sub">{{ $totalTagihan > 0 ? round(($totalTunggakan / $totalTagihan) * 100) : 0 }}% dari total</p>
            </div>

            <div class="stat-card col-span-2 sm:col-span-1 lg:col-span-2">
                <div class="flex items-center gap-4">
                    <div class="stat-icon bg-cyan-500/20">
                        <svg class="h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="stat-label">Progress Pembayaran</p>
                        <p class="mt-1 text-xs text-white/50">{{ $totalLunas + $totalTunggakan + $totalBelum > 0 ? round(($totalLunas / ($totalLunas + $totalTunggakan + $totalBelum)) * 100) : 0 }}% terkumpul</p>
                        @php
                            $progress = ($totalLunas + $totalTunggakan + $totalBelum) > 0
                                ? round(($totalLunas / ($totalLunas + $totalTunggakan + $totalBelum)) * 100)
                                : 0;
                        @endphp
                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-white/10">
                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400 transition-all duration-500" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ Action Panel — Generate Tagihan ═══ --}}
        <div class="action-panel">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h3 class="panel-title">
                        <svg class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Generate Tagihan SPP
                    </h3>
                    <p class="panel-desc">Buat tagihan SPP massal untuk semua siswa berdasarkan tahun dan kelas.</p>
                </div>

                <form method="POST" action="{{ route('spp.generate') }}" class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-end">
                    @csrf
                    <div>
                        <label class="form-label block mb-1">Kelas</label>
                        <select name="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label block mb-1">Tahun</label>
                        <input type="number" name="tahun" value="{{ old('tahun', now()->year) }}"
                               min="2020" max="2099" class="form-input w-28">
                    </div>
                    <div>
                        <label class="form-label block mb-1">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', 50000) }}"
                               min="0" class="form-input w-36">
                    </div>
                    <button type="submit" class="btn-primary whitespace-nowrap"
                            onclick="return confirm('Generate tagihan SPP untuk semua siswa?')">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Generate
                    </button>
                </form>
            </div>
        </div>

        {{-- ═══ Filter ═══ --}}
        <div class="content-card">
            <div class="section-title mb-3">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                </svg>
                Filter Tagihan
            </div>
            <form method="GET" action="{{ route('spp.index') }}" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="form-label block mb-1">Kelas</label>
                    <select name="kelas" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label block mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="tunggakan" {{ request('status') == 'tunggakan' ? 'selected' : '' }}>Tunggakan</option>
                    </select>
                </div>
                <div>
                    <label class="form-label block mb-1">Tahun</label>
                    <input type="number" name="tahun" value="{{ request('tahun', now()->year) }}"
                           class="form-input w-24" placeholder="Tahun">
                </div>
                <button type="submit" class="btn-secondary text-xs">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    Filter
                </button>
                @if (request()->anyFilled(['kelas', 'status', 'tahun']))
                    <a href="{{ route('spp.index') }}" class="btn-secondary text-xs">
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
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th class="text-right">Jumlah</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihan as $t)
                        @php
                            $statusClass = $t->status === 'lunas' ? 'lunas' : ($t->status === 'tunggakan' ? 'tunggakan' : 'belum');
                        @endphp
                        <tr class="status-row-{{ $statusClass }}">
                            <td class="font-medium text-white">{{ $t->siswa->nama_lengkap ?? '-' }}</td>
                            <td class="text-white/60">{{ $t->siswa->kelas ?? '-' }}</td>
                            <td class="text-white/80">{{ $t->nama_bulan }}</td>
                            <td class="text-white/80">{{ $t->tahun }}</td>
                            <td class="text-right font-medium text-white/90">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if ($t->status === 'lunas')
                                    <span class="status-capsule status-capsule-lunas">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Lunas
                                    </span>
                                @elseif ($t->status === 'tunggakan')
                                    <span class="status-capsule status-capsule-tunggakan">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                        Tunggakan
                                    </span>
                                @else
                                    <span class="status-capsule status-capsule-belum">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Belum
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($t->status !== 'lunas')
                                    <form action="{{ route('spp.mark-paid', $t) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-success text-xs"
                                                onclick="return confirm('Tandai {{ $t->nama_bulan }} {{ $t->tahun }} sebagai lunas?')">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Tandai Lunas
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs text-emerald-400/70">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="flex flex-col items-center justify-center py-12">
                                    <svg class="mb-3 h-12 w-12 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>
                                    <p class="text-sm font-medium text-white/40">Belum ada tagihan SPP</p>
                                    <p class="mt-1 text-xs text-white/30">Gunakan panel "Generate Tagihan" di atas untuk membuat tagihan baru.</p>
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
                Menampilkan {{ $tagihan->firstItem() ?? 0 }} - {{ $tagihan->lastItem() ?? 0 }} dari {{ $tagihan->total() }} tagihan
            </p>
            <div class="text-white/60">
                {{ $tagihan->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
