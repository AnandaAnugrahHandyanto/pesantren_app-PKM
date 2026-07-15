<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Tambah Transaksi</h1>
    </x-slot>

    <div class="mx-auto max-w-2xl">
        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-400/30 bg-red-500/20 px-4 py-3 text-sm text-red-200 backdrop-blur-sm">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('keuangan.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="tanggal" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Tanggal <span aria-hidden="true">*</span></label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', today()->toDateString()) }}" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('tanggal') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="jenis" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Jenis <span aria-hidden="true">*</span></label>
                        <div class="relative">
                            <select id="jenis" name="jenis" required
                                class="w-full appearance-none rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 pr-10 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                                <option value="" disabled {{ old('jenis') ? '' : 'selected' }} class="bg-indigo-950 text-slate-900 dark:text-white">Pilih jenis</option>
                                <option value="pemasukan" {{ old('jenis') === 'pemasukan' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Pemasukan</option>
                                <option value="pengeluaran" {{ old('jenis') === 'pengeluaran' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Pengeluaran</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-slate-900 dark:text-slate-500 dark:text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                        @error('jenis') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="kategori" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Kategori</label>
                        <input type="text" id="kategori" name="kategori" value="{{ old('kategori') }}"
                            placeholder="Misal: SPP, Buku, Kegiatan"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white placeholder-white/40 backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('kategori') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="jumlah" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Jumlah (Rp) <span aria-hidden="true">*</span></label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="0" step="0.01" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('jumlah') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="siswa_id" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Siswa (opsional)</label>
                        <div class="relative">
                            <select id="siswa_id" name="siswa_id"
                                class="w-full appearance-none rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 pr-10 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                                <option value="" {{ old('siswa_id') ? '' : 'selected' }} class="bg-indigo-950 text-slate-900 dark:text-white">- Tidak terkait siswa -</option>
                                @foreach ($siswas as $siswa)
                                    <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">{{ $siswa->nis }} - {{ $siswa->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-slate-900 dark:text-slate-500 dark:text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                        @error('siswa_id') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="keterangan" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-slate-900 dark:text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Simpan
                    </button>
                    <a href="{{ route('keuangan.index') }}"
                        class="rounded-lg border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-5 py-2 text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>