<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-white">💰 Manajemen SPP</h2>
            <a href="{{ route('spp.create') }}"
               class="rounded-xl bg-cyan-500/20 px-4 py-2 text-sm font-medium text-cyan-200 ring-1 ring-cyan-400/30 transition hover:bg-cyan-500/30">
                + Generate Tagihan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Filter --}}
            <form method="GET" class="mb-6 flex flex-wrap gap-3">
                <select name="kelas" class="rounded-xl border-white/20 bg-white/10 px-3 py-2 text-sm text-white">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-xl border-white/20 bg-white/10 px-3 py-2 text-sm text-white">
                    <option value="">Semua Status</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="tunggakan" {{ request('status') == 'tunggakan' ? 'selected' : '' }}>Tunggakan</option>
                </select>
                <input type="number" name="tahun" value="{{ request('tahun', now()->year) }}"
                       class="w-24 rounded-xl border-white/20 bg-white/10 px-3 py-2 text-sm text-white" placeholder="Tahun">
                <button type="submit" class="rounded-xl bg-white/10 px-4 py-2 text-sm text-white hover:bg-white/20">Filter</button>
            </form>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-xs uppercase tracking-wider text-white/50">
                            <th class="px-4 py-3 font-medium">Siswa</th>
                            <th class="px-4 py-3 font-medium">Kelas</th>
                            <th class="px-4 py-3 font-medium">Bulan</th>
                            <th class="px-4 py-3 font-medium">Tahun</th>
                            <th class="px-4 py-3 font-medium">Jumlah</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tagihan as $t)
                        <tr class="border-b border-white/5 transition hover:bg-white/5">
                            <td class="px-4 py-3 text-white/80">{{ $t->siswa->nama_lengkap ?? '-' }}</td>
                            <td class="px-4 py-3 text-white/60">{{ $t->siswa->kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-white/80">{{ $t->nama_bulan }}</td>
                            <td class="px-4 py-3 text-white/80">{{ $t->tahun }}</td>
                            <td class="px-4 py-3 text-white/80">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="status-capsule status-{{ $t->status === 'lunas' ? 'hadir' : ($t->status === 'tunggakan' ? 'alfa' : 'izin') }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($t->status !== 'lunas')
                                    <form action="{{ route('spp.mark-paid', $t) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-lg bg-emerald-500/20 px-3 py-1 text-xs font-medium text-emerald-200 ring-1 ring-emerald-400/30 hover:bg-emerald-500/30"
                                                onclick="return confirm('Tandai {{ $t->nama_bulan }} {{ $t->tahun }} sebagai lunas?')">
                                            Tandai Lunas
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-emerald-400/60">✅ Lunas</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-white/40">Belum ada tagihan SPP.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tagihan->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
