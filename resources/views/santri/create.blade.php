<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Tambah Santri</h1>
    </x-slot>

    <div class="mx-auto max-w-xl">
        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('santri.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="nama_lengkap" class="mb-1 block text-sm font-medium text-white/80">Nama Lengkap <span aria-hidden="true">*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" maxlength="255" required aria-required="true"
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    @error('nama_lengkap')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kelas" class="mb-1 block text-sm font-medium text-white/80">Kelas <span aria-hidden="true">*</span></label>
                    <input type="text" id="kelas" name="kelas" value="{{ old('kelas') }}" maxlength="255" required aria-required="true"
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    @error('kelas')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="mb-1 block text-sm font-medium text-white/80">Jenis Kelamin <span aria-hidden="true">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required aria-required="true" aria-label="Pilih jenis kelamin"
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }} aria-hidden="true" class="bg-indigo-950 text-white">Pilih jenis kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }} class="bg-indigo-950 text-white">Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }} class="bg-indigo-950 text-white">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Simpan
                    </button>
                    <a href="{{ route('santri.index') }}"
                        class="rounded-lg border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

