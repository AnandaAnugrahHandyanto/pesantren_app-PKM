<x-app-layout>

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
            <form action="{{ route('guru.update', $guru) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')

                {{-- Account Info Section --}}
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-cyan-300">Informasi Akun Login</h3>
                    <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Username tidak bisa diubah. Kosongkan password jika tidak ingin mengganti.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="username" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Username <span class="text-red-400">*</span></label>
                        <input type="text" id="username" name="username" value="{{ old('username', $guru->user?->username) }}" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('username') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Email <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $guru->email) }}" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('email') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Password Baru</label>
                        <input type="password" id="password" name="password"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('password') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    </div>
                </div>

                {{-- Profile Info Section --}}
                <div class="mb-4 mt-6">
                    <h3 class="text-sm font-semibold text-cyan-300">Data Profil Guru</h3>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="nama_lengkap" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('nama_lengkap') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nip" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">NIP</label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('nip') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">No. HP</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('no_hp') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Jenis Kelamin <span class="text-red-400">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                            <option value="" disabled class="bg-indigo-950 text-slate-900 dark:text-white">Pilih jenis kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'L' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'P' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $guru->tanggal_lahir?->toDateString()) }}"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('tanggal_lahir') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal_masuk" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Tanggal Masuk</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', $guru->tanggal_masuk?->toDateString()) }}"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('tanggal_masuk') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="foto" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Foto</label>
                        @if ($guru->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto {{ $guru->nama_lengkap }}" class="h-20 w-20 rounded-lg object-cover">
                            </div>
                        @endif
                        <input type="file" id="foto" name="foto" accept="image/*"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm file:mr-2 file:rounded file:border-0 file:bg-indigo-500/30 file:px-2 file:py-1 file:text-xs file:text-slate-900 dark:text-white focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('foto') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="alamat" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3"
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">{{ old('alamat', $guru->alamat) }}</textarea>
                    @error('alamat') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-slate-900 dark:text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Update
                    </button>
                    <a href="{{ route('guru.index') }}"
                        class="rounded-lg border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-5 py-2 text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>