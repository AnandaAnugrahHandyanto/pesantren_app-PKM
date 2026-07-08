<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-lg font-semibold">Keuangan</h1>
            <a href="{{ route('keuangan.create') }}"
                class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                + Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="space-y-4">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-400/30 bg-emerald-500/20 px-4 py-3 text-sm text-emerald-200 backdrop-blur-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ringkasan Saldo --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-4 shadow-lg backdrop-blur-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-300/80">Pemasukan</p>
                <p class="mt-1 text-2xl font-bold text-emerald-200">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-2xl border border-rose-400/20 bg-rose-500/10 p-4 shadow-lg backdrop-blur-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-rose-300/80">Pengeluaran</p>
                <p class="mt-1 text-2xl font-bold text-rose-200">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-2xl border border-blue-400/20 bg-blue-500/10 p-4 shadow-lg backdrop-blur-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-300/80">Saldo</p>
                <p class="mt-1 text-2xl font-bold text-blue-200">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="rounded-2xl border border-white/20 bg-white/10 p-4 shadow-lg backdrop-blur-md">
            <form method="GET" action="{{ route('keuangan.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end sm:flex-wrap">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Bulan</label>
                    <select name="bulan"
                        class="rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="" {{ !request('bulan') ? 'selected' : '' }} class="bg-indigo-950 text-white">Semua Bulan</option>
                        @foreach ($bulanOptions as $val => $label)
                            <option value="{{ $val }}" {{ request('bulan') == $val ? 'selected' : '' }} class="bg-indigo-950 text-white">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Tahun</label>
                    <select name="tahun"
                        class="rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="" {{ !request('tahun') ? 'selected' : '' }} class="bg-indigo-950 text-white">Semua Tahun</option>
                        @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }} class="bg-indigo-950 text-white">{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-medium text-white/70">Jenis</label>
                    <select name="jenis"
                        class="rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="" {{ !request('jenis') ? 'selected' : '' }} class="bg-indigo-950 text-white">Semua</option>
                        <option value="pemasukan" {{ request('jenis') === 'pemasukan' ? 'selected' : '' }} class="bg-indigo-950 text-white">Pemasukan</option>
                        <option value="pengeluaran" {{ request('jenis') === 'pengeluaran' ? 'selected' : '' }} class="bg-indigo-950 text-white">Pengeluaran</option>
                    </select>
                </div>

                <button type="submit"
                    class="rounded-lg bg-indigo-500/80 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-indigo-400/80">
                    Filter
                </button>

                @if (request()->anyFilled(['bulan', 'tahun', 'jenis']))
                    <a href="{{ route('keuangan.index') }}"
                        class="rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur-md">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-white/15 bg-white/10">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Jenis</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Keterangan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/70">Siswa</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-white/70">Jumlah</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-white/70">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($keuangans as $k)
                        <tr class="transition hover:bg-white/[0.04]">
                            <td class="whitespace-nowrap px-4 py-3 text-white/70">{{ $k->tanggal->format('d M Y') }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if ($k->jenis === 'pemasukan')
                                    <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-2.5 py-0.5 text-xs font-medium text-emerald-200 border border-emerald-400/30">
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-rose-500/20 px-2.5 py-0.5 text-xs font-medium text-rose-200 border border-rose-400/30">
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-white/70">{{ $k->kategori ?? '-' }}</td>
                            <td class="px-4 py-3 text-white/70 max-w-xs truncate">{{ $k->keterangan ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-white/70">{{ $k->siswa?->nama_lengkap ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right font-medium {{ $k->jenis === 'pemasukan' ? 'text-emerald-200' : 'text-rose-200' }}">
                                Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('keuangan.edit', $k) }}"
                                        class="rounded-lg border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                                        Edit
                                    </a>
                                    <form action="{{ route('keuangan.destroy', $k) }}" method="POST"
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
                            <td colspan="7" class="px-4 py-16 text-center text-sm text-white/40">
                                Belum ada data transaksi.
                                <a href="{{ route('keuangan.create') }}" class="text-indigo-300 underline hover:text-indigo-200">Tambah transaksi</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between">
            <div class="text-xs text-white/40">
                Total: {{ $keuangans->total() }} transaksi
            </div>
            <div class="text-xs text-white/40">
                {{ $keuangans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>