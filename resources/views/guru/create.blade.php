<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500/20 ring-1 ring-amber-400/30">
                <svg class="h-5 w-5 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Tambah Guru</h1>
                <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Buat data guru beserta akun login</p>
            </div>
        </div>
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
            <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Account Info Section --}}
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-cyan-300">Informasi Akun Login</h3>
                    <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Data yang digunakan guru untuk login ke sistem</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="username" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Username <span class="text-red-400">*</span></label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('username') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Email <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('email') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Password Default <span class="text-red-400">*</span></label>
                        <input type="password" id="password" name="password" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('password') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Konfirmasi Password <span class="text-red-400">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    </div>
                </div>

                {{-- Profile Info Section --}}
                <div class="mb-4 mt-6">
                    <h3 class="text-sm font-semibold text-cyan-300">Data Profil Guru</h3>
                    <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Informasi lengkap data diri guru</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="nama_lengkap" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('nama_lengkap') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nip" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">NIP</label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('nip') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">No. HP</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('no_hp') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Jenis Kelamin <span class="text-red-400">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }} class="bg-indigo-950 text-slate-900 dark:text-white">Pilih jenis kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('tanggal_lahir') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal_masuk" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Tanggal Masuk</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('tanggal_masuk') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="foto" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Foto</label>
                        <input type="file" id="foto" name="foto" accept="image/*"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm file:mr-2 file:rounded file:border-0 file:bg-indigo-500/30 file:px-2 file:py-1 file:text-xs file:text-slate-900 dark:text-white focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @error('foto') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="alamat" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3"
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-slate-900 dark:text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Simpan
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