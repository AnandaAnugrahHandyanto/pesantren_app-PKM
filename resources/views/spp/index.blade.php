<x-app-layout>

    <div class="space-y-6">
        @if (session('success'))
            <div class="alert-success flex items-center gap-2">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ═══ Action Panel ═══ --}}
        <div class="action-panel">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h3 class="panel-title">Generate Tagihan SPP</h3>
                    <p class="panel-desc">Buat tagihan SPP massal untuk semua siswa.</p>
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
                        <input type="number" name="tahun" value="{{ old('tahun', now()->year) }}" class="form-input w-28">
                    </div>
                    <div>
                        <label class="form-label block mb-1">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', 50000) }}" class="form-input w-36">
                    </div>
                    <button type="submit" class="btn-primary" onclick="return confirm('Generate tagihan massal?')">Generate</button>
                </form>
            </div>
        </div>

        {{-- ═══ Filter ═══ --}}
        <div class="content-card">
            <form method="GET" action="{{ route('spp.index') }}" class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-input w-full" placeholder="Cari nama atau NIS siswa...">
                </div>
                <select name="kelas" class="form-select w-full">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-select w-full">
                    <option value="">Semua Status</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="tunggakan" {{ request('status') == 'tunggakan' ? 'selected' : '' }}>Tunggakan</option>
                </select>
                <button type="submit" class="btn-secondary w-full">Filter</button>
            </form>
        </div>

        {{-- ═══ Daftar Siswa ═══ --}}
        <div class="space-y-3">
            @forelse($siswaList as $siswa)
                <div class="rounded-xl border border-slate-300 dark:border-white/10 bg-white dark:bg-white/5" x-data="{
                    open: false,
                    summary: {
                        total: {{ $siswa->sppBills->count() }},
                        lunas: {{ $siswa->sppBills->where('status', 'lunas')->count() }},
                        belum: {{ $siswa->sppBills->where('status', 'belum')->count() }},
                        tunggakan: {{ $siswa->sppBills->where('status', 'tunggakan')->count() }},
                        sisa_tagihan: {{ $siswa->sppBills->whereIn('status', ['belum', 'tunggakan'])->sum('jumlah') }},
                        formatted_sisa_tagihan: 'Rp {{ number_format($siswa->sppBills->whereIn('status', ['belum', 'tunggakan'])->sum('jumlah'), 0, ',', '.') }}'
                    }
                }">
                    <div class="flex items-center gap-4 p-4 cursor-pointer" @click="open = !open">
                        <div class="flex-1">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $siswa->nama_lengkap }}</p>
                            <p class="text-xs text-slate-600 dark:text-slate-400">{{ $siswa->nis }} &bull; {{ $siswa->kelas }}</p>
                            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs">
                                <span class="text-slate-500">Total: <strong class="text-slate-900 dark:text-white" x-text="summary.total"></strong></span>
                                <span class="text-emerald-500">Lunas: <strong class="text-emerald-600" x-text="summary.lunas"></strong></span>
                                <span class="text-amber-500">Belum: <strong class="text-amber-600" x-text="summary.belum"></strong></span>
                                <span class="text-red-500">Tunggakan: <strong class="text-red-600" x-text="summary.tunggakan"></strong></span>
                            </div>
                        </div>
                        <div class="text-right">
                             <p class="text-sm font-semibold text-slate-900 dark:text-white" x-text="summary.formatted_sisa_tagihan"></p>
                        </div>
                        <button class="flex-shrink-0 text-slate-400"><svg class="h-5 w-5" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" /></svg></button>
                    </div>

                    <div class="border-t border-slate-200 dark:border-white/10" x-show="open" x-cloak>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-slate-50 dark:bg-white/5 text-xs text-slate-500 dark:text-slate-400">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Bulan</th>
                                        <th class="px-4 py-2 text-left">Tahun</th>
                                        <th class="px-4 py-2 text-right">Jumlah</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                        <th class="px-4 py-2 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                                    @foreach($siswa->sppBills as $bill)
                                    <tr x-data="{ editing: false, jumlah: {{ $bill->jumlah }}, formatted_jumlah: 'Rp {{ number_format($bill->jumlah, 0, ',', '.') }}', billId: {{ $bill->id }}, status: '{{ $bill->status }}' }">
                                        <td class="px-4 py-3 text-sm text-slate-800 dark:text-slate-300">{{ $bill->nama_bulan }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $bill->tahun }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-right text-slate-900 dark:text-white">
                                            <span x-show="!editing" class="whitespace-nowrap font-medium" x-text="formatted_jumlah"></span>
                                            <input x-show="editing" type="number" x-model="jumlah" class="w-24 form-input py-1 text-xs">
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                                  :class="{
                                                      'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300': status === 'lunas',
                                                      'bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300': status === 'tunggakan',
                                                      'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300': status === 'belum'
                                                  }" x-text="status.charAt(0).toUpperCase() + status.slice(1)"></span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div x-show="!editing">
                                                <div x-show="status !== 'lunas'" class="flex justify-end gap-2">
                                                    <button type="button" @click="editing = true" class="btn-primary text-xs py-1 px-2">Edit</button>
                                                    <button type="button" @click="if(confirm('Hapus tagihan?')) {
                                                        fetch('/spp/'+billId, {method: 'DELETE', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}})
                                                        .then(res => res.ok ? res.json() : Promise.reject('Gagal menghapus'))
                                                        .then(data => { if(data.success) { $el.closest('tr').remove(); summary = data.summary; } else { alert(data.message); } })
                                                        .catch(err => alert(err));
                                                    }" class="btn-danger text-xs py-1 px-2">Hapus</button>
                                                    <button type="button" @click="if(confirm('Tandai lunas?')) {
                                                        fetch('/spp/'+billId+'/paid', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}})
                                                        .then(res => res.ok ? res.json() : Promise.reject('Gagal memproses'))
                                                        .then(data => { if(data.success) { status = 'lunas'; summary = data.summary; } else { alert(data.message); } })
                                                        .catch(err => alert(err));
                                                    }" class="btn-success text-xs py-1 px-2">Tandai Lunas</button>
                                                </div>
                                                <div x-show="status === 'lunas'">
                                                    <span class="text-xs text-emerald-400/70">Selesai</span>
                                                </div>
                                            </div>
                                            <div x-show="editing" class="flex justify-end gap-1" x-data="{ error: '' }">
                                                <form x-show="editing" @click.stop @submit.prevent="
                                                    const jumlahVal = jumlah;
                                                    fetch('/spp/'+billId, {
                                                        method: 'PUT',
                                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                                                        body: JSON.stringify({ jumlah: jumlahVal })
                                                    }).then(res => {
                                                        if (res.ok) return res.json();
                                                        return res.json().then(data => {
                                                            let msg = data.errors?.jumlah?.[0] || data.message || 'Error';
                                                            throw new Error(msg);
                                                        });
                                                    }).then(data => {
                                                        editing = false;
                                                        error = '';
                                                        jumlah = data.bill.jumlah;
                                                        formatted_jumlah = data.bill.formatted_jumlah;
                                                        summary = data.summary;
                                                    }).catch(err => { error = err.message; });
                                                " class="flex flex-col items-end gap-1">
                                                    <input type="number" x-model="jumlah" min="1" class="w-24 form-input py-1 text-xs" required>
                                                    <div x-show="error" class="text-[10px] text-red-500" x-text="error"></div>
                                                    <div class="flex gap-1 mt-1">
                                                        <button type="submit" class="btn-primary text-xs py-1 px-2">Simpan</button>
                                                        <button type="button" @click="editing = false; error = ''; jumlah = {{ $bill->jumlah }}" class="btn-secondary text-xs py-1 px-2">Batal</button>
                                                    </div>
                                                </form>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-slate-900 dark:text-white">Tidak ada data.</p>
            @endforelse
        </div>

        {{-- ═══ Pagination ═══ --}}
        <div class="pagination-wrap">
            {{ $siswaList->links() }}
        </div>
    </div>
</x-app-layout>
