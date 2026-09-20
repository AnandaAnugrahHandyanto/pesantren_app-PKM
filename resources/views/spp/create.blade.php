<x-app-layout>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="action-panel">
                <form method="POST" action="{{ route('spp.generate') }}">
                    @csrf

                    <div class="space-y-5">
                        <div>
                            <label class="form-label block mb-1.5">Tahun Ajaran</label>
                            <input type="number" name="tahun" value="{{ old('tahun', now()->year) }}"
                                   min="2020" max="2099" required
                                   class="form-input">
                            @error('tahun') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="form-label block mb-1.5">Jumlah SPP per Bulan (Rp)</label>
                            <input type="number" name="jumlah" value="{{ old('jumlah', 50000) }}"
                                   min="0" required
                                   class="form-input">
                            @error('jumlah') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="form-label block mb-1.5">Filter Kelas (opsional)</label>
                            <select name="kelas" class="form-select">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-slate-900 dark:text-slate-400 dark:text-white/40">Jika tidak dipilih, semua siswa akan dibuatkan tagihan.</p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-xl border border-amber-400/20 bg-amber-500/10 p-4 text-sm text-amber-200">
                        <div class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-amber-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>Akan generate <strong>12 tagihan</strong> (Jan–Des) per siswa untuk tahun yang dipilih. Tagihan yang sudah ada akan dilewati secara otomatis.</span>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="btn-primary"
                                onclick="return confirm('Generate tagihan SPP untuk {{ old('kelas', 'semua') }} tahun {{ old('tahun', now()->year) }}?')">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Generate Tagihan
                        </button>
                        <a href="{{ route('spp.index') }}" class="btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
