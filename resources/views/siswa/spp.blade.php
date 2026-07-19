<x-app-layout>

    <div class="space-y-6">
        {{-- ═══ Statistik ═══ --}}
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <div class="stat-card">
                <div class="stat-icon bg-slate-50 dark:bg-white/10">
                    <svg class="h-5 w-5 text-slate-900 dark:text-slate-600 dark:text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <p class="stat-label">Tagihan</p>
                <p class="stat-value text-slate-900 dark:text-white">{{ $totalTagihan }}</p>
                <p class="stat-sub">Bulan di tahun {{ now()->year }}</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-emerald-500/20">
                    <svg class="h-5 w-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="stat-label">Lunas</p>
                <p class="stat-value text-emerald-300">{{ $totalLunas }}</p>
                <p class="stat-sub">Rp {{ number_format($jumlahLunas, 0, ',', '.') }}</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-amber-500/20">
                    <svg class="h-5 w-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="stat-label">Belum Dibayar</p>
                <p class="stat-value text-amber-300">{{ $totalBelum + $totalTunggakan }}</p>
                <p class="stat-sub">{{ $totalBelum }} belum + {{ $totalTunggakan }} tunggakan</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-cyan-500/20">
                    <svg class="h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <p class="stat-label">Total</p>
                <p class="stat-value text-cyan-300">Rp {{ number_format($jumlahTotal, 0, ',', '.') }}</p>
                <p class="stat-sub">{{ $totalTagihan > 0 ? round(($totalLunas / $totalTagihan) * 100) : 0 }}% terkumpul</p>
            </div>
        </div>

        {{-- Progress Bar --}}
        @if($totalTagihan > 0)
            @php $progress = round(($totalLunas / $totalTagihan) * 100); @endphp
            <div class="content-card">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/50">Progress Pembayaran</p>
                    <p class="text-xs font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">{{ $progress }}%</p>
                </div>
                <div class="h-2.5 overflow-hidden rounded-full bg-slate-50 dark:bg-white/10">
                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400 transition-all duration-500" style="width: {{ $progress }}%"></div>
                </div>
                <p class="mt-2 text-xs text-slate-900 dark:text-slate-400 dark:text-white/40">{{ $totalLunas }} dari {{ $totalTagihan }} bulan sudah lunas</p>
            </div>
        @endif

        {{-- ═══ Tabel ═══ --}}
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/60">Riwayat Tagihan</h3>
            <button type="button" 
                class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-white/5 rounded-lg hover:bg-slate-200 dark:hover:bg-white/10 transition"
                onclick="document.getElementById('modal-panduan-pembayaran').classList.remove('hidden')">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
                Panduan Pembayaran
            </button>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th class="text-right">Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihan as $t)
                        @php
                            $statusClass = $t->status === 'lunas' ? 'lunas' : ($t->status === 'tunggakan' ? 'tunggakan' : 'belum');
                        @endphp
                        <tr class="status-row-{{ $statusClass }}">
                            <td class="font-medium text-slate-900 dark:text-white">{{ $t->nama_bulan }}</td>
                            <td class="text-right font-medium text-slate-900 dark:text-slate-800 dark:text-white/90">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if($t->status === 'lunas')
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Lunas
                                    </span>
                                @elseif($t->status === 'tunggakan')
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                        Tunggakan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Belum
                                    </span>
                                @endif
                            </td>
                            <td class="text-slate-900 dark:text-slate-500 dark:text-white/60">
                                {{ $t->paid_at ? \Carbon\Carbon::parse($t->paid_at)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2 min-h-[40px]">
                                    @if($t->status !== 'lunas')
                                        <button type="button" 
                                            class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300"
                                            onclick="document.getElementById('modal-panduan-pembayaran').classList.remove('hidden')">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </button>
                                        <button type="button" 
                                            onclick="initPayment('{{ route('spp.checkout', $t->id) }}')"
                                            class="btn-primary text-xs py-1.5 px-3">
                                            Bayar Sekarang
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="flex flex-col items-center justify-center py-12">
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-400 dark:text-white/40">Belum ada tagihan SPP untuk tahun ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Ringkasan --}}
        <div class="content-card">
            <div class="flex items-center justify-center gap-6 text-sm">
                <div class="text-center">
                    <p class="text-2xl font-bold text-emerald-300">{{ $totalLunas }}</p>
                    <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Lunas</p>
                </div>
                <div class="h-8 w-px bg-slate-50 dark:bg-white/10"></div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-amber-300">{{ $totalBelum + $totalTunggakan }}</p>
                    <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Belum Dibayar</p>
                </div>
                <div class="h-8 w-px bg-slate-50 dark:bg-white/10"></div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalTagihan }}</p>
                    <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Total Tagihan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap Script --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    
    {{-- Modal Panduan Pembayaran --}}
    <div id="modal-panduan-pembayaran" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg p-6 relative">
            <button onclick="document.getElementById('modal-panduan-pembayaran').classList.add('hidden')" class="absolute top-4 right-4 text-slate-500 hover:text-slate-800 dark:hover:text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Cara Pembayaran SPP Online</h2>
            
            <div class="space-y-4 text-sm text-slate-700 dark:text-slate-300 max-h-[60vh] overflow-y-auto pr-2">
                <div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">1. Pembayaran menggunakan QRIS</h3>
                    <ol class="list-decimal ml-5 space-y-1">
                        <li>Klik tombol "Bayar Sekarang".</li>
                        <li>Jendela pembayaran Midtrans akan terbuka.</li>
                        <li>Pilih metode pembayaran QRIS.</li>
                        <li>Scan QR menggunakan aplikasi Mobile Banking atau E-Wallet.</li>
                        <li>Pastikan nominal pembayaran sudah benar.</li>
                        <li>Selesaikan pembayaran.</li>
                        <li>Tunggu hingga status pembayaran diperbarui otomatis.</li>
                    </ol>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">2. Pembayaran menggunakan Virtual Account</h3>
                    <ol class="list-decimal ml-5 space-y-1">
                        <li>Klik tombol "Bayar Sekarang".</li>
                        <li>Jendela pembayaran Midtrans akan terbuka.</li>
                        <li>Pilih metode Virtual Account.</li>
                        <li>Pilih bank yang diinginkan.</li>
                        <li>Salin nomor Virtual Account.</li>
                        <li>Buka Mobile Banking / Internet Banking / ATM.</li>
                        <li>Pilih menu Virtual Account.</li>
                        <li>Masukkan nomor Virtual Account.</li>
                        <li>Konfirmasi pembayaran.</li>
                        <li>Tunggu hingga status pembayaran berubah otomatis menjadi Lunas.</li>
                    </ol>
                </div>
                <div class="pt-2 border-t border-slate-200 dark:border-slate-700">
                    <h3 class="font-semibold text-slate-900 dark:text-white">3. Catatan Penting</h3>
                    <ul class="list-disc ml-5 space-y-1">
                        <li>Jangan menutup halaman pembayaran sebelum proses selesai.</li>
                        <li>Status pembayaran biasanya diperbarui otomatis dalam beberapa detik hingga beberapa menit setelah transaksi berhasil.</li>
                        <li>Jika pembayaran berhasil tetapi status belum berubah, tunggu beberapa menit lalu refresh halaman.</li>
                        <li>Jika masih mengalami kendala, hubungi Admin Sekolah.</li>
                    </ul>
                </div>
                <div class="pt-3 border-t border-slate-200 dark:border-slate-700 text-center">
                    <p class="text-xs text-slate-500 dark:text-slate-400">Pembayaran diproses secara aman melalui Midtrans Payment Gateway. Status pembayaran akan diperbarui secara otomatis setelah transaksi berhasil</p>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button onclick="document.getElementById('modal-panduan-pembayaran').classList.add('hidden')" 
                        class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-900 dark:text-white rounded-lg text-sm font-semibold transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function initPayment(checkoutUrl) {
            fetch(checkoutUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result){ alert("Pembayaran Berhasil!"); location.reload(); },
                        onPending: function(result){ alert("Menunggu Pembayaran!"); },
                        onError: function(result){ alert("Pembayaran Gagal!"); },
                        onClose: function(){ alert('Anda menutup popup tanpa menyelesaikan pembayaran.'); }
                    });
                } else {
                    alert(data.message || "Gagal memproses pembayaran");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Terjadi kesalahan sistem");
            });
        }
    </script>
</x-app-layout>
