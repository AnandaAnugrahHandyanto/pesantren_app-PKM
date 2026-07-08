<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">💰 Tagihan SPP Saya</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            @if($tagihan->isEmpty())
                <div class="rounded-2xl border border-white/10 bg-white/5 p-8 text-center backdrop-blur-xl">
                    <p class="text-white/40">Belum ada tagihan SPP untuk tahun ini.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-xs uppercase tracking-wider text-white/50">
                                <th class="px-4 py-3 font-medium">Bulan</th>
                                <th class="px-4 py-3 font-medium">Jumlah</th>
                                <th class="px-4 py-3 font-medium">Status</th>
                                <th class="px-4 py-3 font-medium">Tanggal Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tagihan as $t)
                            <tr class="border-b border-white/5 transition hover:bg-white/5">
                                <td class="px-4 py-3 font-medium text-white/80">{{ $t->nama_bulan }}</td>
                                <td class="px-4 py-3 text-white/80">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    @if($t->status === 'lunas')
                                        <span class="status-capsule status-hadir">✅ Lunas</span>
                                    @elseif($t->status === 'tunggakan')
                                        <span class="status-capsule status-alfa">Tunggakan</span>
                                    @else
                                        <span class="status-capsule status-izin">Belum</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-white/60">
                                    {{ $t->paid_at ? \Carbon\Carbon::parse($t->paid_at)->translatedFormat('d M Y') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @php
                    $lunas = $tagihan->where('status', 'lunas')->count();
                    $total = $tagihan->count();
                @endphp
                <div class="mt-4 rounded-xl bg-white/5 p-4 text-center text-sm text-white/60">
                    Status: <span class="font-medium text-emerald-300">{{ $lunas }}</span> / {{ $total }} bulan lunas
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
