<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Edit Santri</h1>
    </x-slot>

    <div class="mx-auto max-w-xl">
        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('santri.update', $santri) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="nis" class="mb-1 block text-sm font-medium text-white/80">NIS <span aria-hidden="true">*</span></label>
                    <input type="text" id="nis" name="nis" value="{{ old('nis', $santri->nis) }}" maxlength="255" required aria-required="true"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                    @error('nis')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama" class="mb-1 block text-sm font-medium text-white/80">Nama <span aria-hidden="true">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $santri->nama) }}" maxlength="255" required aria-required="true"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kelas" class="mb-1 block text-sm font-medium text-white/80">Kelas <span aria-hidden="true">*</span></label>
                    <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $santri->kelas) }}" maxlength="255" required aria-required="true"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                    @error('kelas')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kamar" class="mb-1 block text-sm font-medium text-white/80">Kamar <span aria-hidden="true">*</span></label>
                    <input type="text" id="kamar" name="kamar" value="{{ old('kamar', $santri->kamar) }}" maxlength="255" required aria-required="true"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                    @error('kamar')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="mb-1 block text-sm font-medium text-white/80">Jenis Kelamin <span aria-hidden="true">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required aria-required="true" aria-label="Pilih jenis kelamin"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="" disabled aria-hidden="true" {{ old('jenis_kelamin', $santri->jenis_kelamin) ? '' : 'selected' }} class="bg-indigo-950 text-white">Pilih jenis kelamin</option>
                        <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'L' ? 'selected' : '' }} class="bg-indigo-950 text-white">Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'P' ? 'selected' : '' }} class="bg-indigo-950 text-white">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-xl bg-yellow-500/80 px-5 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-yellow-400/80">
                        Update
                    </button>
                    <a href="{{ route('santri.index') }}"
                        class="rounded-xl border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
