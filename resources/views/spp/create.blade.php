<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">📋 Generate Tagihan SPP</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl">
                <form method="POST" action="{{ route('spp.generate') }}">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-white/70">Tahun</label>
                            <input type="number" name="tahun" value="{{ old('tahun', now()->year) }}" required
                                   class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                            @error('tahun') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-white/70">Jumlah SPP per Bulan (Rp)</label>
                            <input type="number" name="jumlah" value="{{ old('jumlah') }}" required min="0"
                                   class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                            @error('jumlah') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-white/70">Filter Kelas (opsional)</label>
                            <select name="kelas" class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 rounded-xl bg-amber-500/10 p-4 text-sm text-amber-200 ring-1 ring-amber-400/20">
                        ⚠️ Akan generate 12 tagihan (Jan-Des) per siswa. Tagihan yang sudah ada akan dilewati.
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="rounded-xl bg-cyan-500/20 px-6 py-2.5 font-medium text-cyan-200 ring-1 ring-cyan-400/30 hover:bg-cyan-500/30">
                            Generate Tagihan
                        </button>
                        <a href="{{ route('spp.index') }}" class="rounded-xl bg-white/10 px-6 py-2.5 text-white hover:bg-white/20">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
