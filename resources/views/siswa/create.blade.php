<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Tambah Siswa</h1>
    </x-slot>

    <div class="mx-auto max-w-xl">
        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-400/30 bg-red-500/20 px-4 py-3 text-sm text-red-200 backdrop-blur-sm">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('siswa.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="nama_lengkap" class="mb-1 block text-sm font-medium text-white/80">Nama Lengkap <span aria-hidden="true">*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" maxlength="255" required aria-required="true"
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    @error('nama_lengkap')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tingkat" class="mb-1 block text-sm font-medium text-white/80">Tingkat <span aria-hidden="true">*</span></label>
                        <div class="relative">
                            <select id="tingkat" name="tingkat" required aria-label="Pilih tingkat"
                                class="w-full appearance-none rounded-lg border border-white/30 bg-white/10 px-3 py-2 pr-10 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                                <option value="" disabled {{ old('tingkat') ? '' : 'selected' }} class="bg-indigo-950 text-white">Pilih tingkat</option>
                                @foreach ($tingkatOptions as $t)
                                    <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }} class="bg-indigo-950 text-white">Kelas {{ $t }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                        @error('tingkat')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jurusan" class="mb-1 block text-sm font-medium text-white/80">Jurusan <span aria-hidden="true">*</span></label>
                        <div class="relative">
                            <select id="jurusan" name="jurusan" required aria-label="Pilih jurusan"
                                class="w-full appearance-none rounded-lg border border-white/30 bg-white/10 px-3 py-2 pr-10 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                                <option value="" disabled {{ old('jurusan') ? '' : 'selected' }} class="bg-indigo-950 text-white">Pilih jurusan</option>
                                @foreach ($jurusanOptions as $j)
                                    <option value="{{ $j }}" {{ old('jurusan') === $j ? 'selected' : '' }} class="bg-indigo-950 text-white">{{ $j }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                        @error('jurusan')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="jenis_kelamin" class="mb-1 block text-sm font-medium text-white/80">Jenis Kelamin <span aria-hidden="true">*</span></label>
                    <div class="relative">
                        <select id="jenis_kelamin" name="jenis_kelamin" required aria-required="true" aria-label="Pilih jenis kelamin"
                            class="w-full appearance-none rounded-lg border border-white/30 bg-white/10 px-3 py-2 pr-10 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }} aria-hidden="true" class="bg-indigo-950 text-white">Pilih jenis kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }} class="bg-indigo-950 text-white">Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }} class="bg-indigo-950 text-white">Perempuan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-4 w-4 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nis" class="mb-1 block text-sm font-medium text-white/80">NIS</label>
                    <input type="text" id="nis" name="nis" value="{{ old('nis') }}" maxlength="50"
                        placeholder="Kosongkan untuk auto-generate"
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    @error('nis')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Simpan
                    </button>
                    <a href="{{ route('siswa.index') }}"
                        class="rounded-lg border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>