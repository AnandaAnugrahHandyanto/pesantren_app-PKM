<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Edit Guru</h1>
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

        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('guru.update', $guru) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="nip" class="mb-1 block text-sm font-medium text-white/80">NIP <span aria-hidden="true">*</span></label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}" required
                            class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('nip') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nama_lengkap" class="mb-1 block text-sm font-medium text-white/80">Nama Lengkap <span aria-hidden="true">*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required
                            class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('nama_lengkap') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-white/80">Email <span aria-hidden="true">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $guru->email) }}" required
                            class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('email') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="mb-1 block text-sm font-medium text-white/80">No. HP</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}"
                            class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('no_hp') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="mb-1 block text-sm font-medium text-white/80">Jenis Kelamin <span aria-hidden="true">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                            <option value="" disabled class="bg-indigo-950 text-white">Pilih jenis kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'L' ? 'selected' : '' }} class="bg-indigo-950 text-white">Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'P' ? 'selected' : '' }} class="bg-indigo-950 text-white">Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="mb-1 block text-sm font-medium text-white/80">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $guru->tanggal_lahir?->toDateString()) }}"
                            class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('tanggal_lahir') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal_masuk" class="mb-1 block text-sm font-medium text-white/80">Tanggal Masuk</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', $guru->tanggal_masuk?->toDateString()) }}"
                            class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('tanggal_masuk') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="foto" class="mb-1 block text-sm font-medium text-white/80">Foto</label>
                        @if ($guru->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto {{ $guru->nama_lengkap }}" class="h-20 w-20 rounded-lg object-cover">
                            </div>
                        @endif
                        <input type="file" id="foto" name="foto" accept="image/*"
                            class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm file:mr-2 file:rounded file:border-0 file:bg-indigo-500/30 file:px-2 file:py-1 file:text-xs file:text-white focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('foto') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="alamat" class="mb-1 block text-sm font-medium text-white/80">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3"
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">{{ old('alamat', $guru->alamat) }}</textarea>
                    @error('alamat') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Update
                    </button>
                    <a href="{{ route('guru.index') }}"
                        class="rounded-lg border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>