<x-app-layout>

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

        <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('siswa.update', $siswa) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama_lengkap" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Nama Lengkap <span aria-hidden="true">*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" maxlength="255" required aria-required="true"
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white placeholder-white/40 backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    @error('nama_lengkap')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="kelas_v2" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Kelas <span aria-hidden="true">*</span></label>
                        <div class="relative">
                            <select id="kelas_v2" name="kelas_v2" required aria-label="Pilih Kelas"
                                class="w-full appearance-none rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 pr-10 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                                <option value="" disabled class="bg-indigo-950 text-slate-900 dark:text-white">Pilih Kelas</option>
                                @foreach ($kelasOptions as $t)
                                    <option value="{{ $t }}" {{ old('kelas_v2', $siswa->kelas_v2) == $t ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Kelas {{ $t }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-slate-900 dark:text-slate-500 dark:text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                        @error('kelas_v2')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rombel" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Rombel <span aria-hidden="true">*</span></label>
                                                <div class="relative">
                                                    <select id="rombel" name="rombel" required aria-label="Pilih rombel"
                                                            class="w-full appearance-none rounded-xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2.5 pr-10 text-sm text-slate-900 dark:text-white backdrop-blur-sm transition focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                                                        <option value="" disabled class="bg-indigo-950 text-slate-900 dark:text-white">Pilih rombel</option>
                                                        @foreach ($rombelOptions as $j)
                                                            <option value="{{ $j }}" {{ old('rombel', $siswa->rombel) === $j ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">{{ $j }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-900 dark:text-slate-400 dark:text-white/40">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                @error('rombel')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="jenis_kelamin" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Jenis Kelamin <span aria-hidden="true">*</span></label>
                    <div class="relative">
                        <select id="jenis_kelamin" name="jenis_kelamin" required aria-required="true" aria-label="Pilih jenis kelamin"
                            class="w-full appearance-none rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 pr-10 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                            <option value="" disabled aria-hidden="true" class="bg-indigo-950 text-slate-900 dark:text-white">Pilih jenis kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Perempuan</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-4 w-4 text-slate-900 dark:text-slate-500 dark:text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nis" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">NIS</label>
                    <input type="text" id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}" maxlength="50"
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white placeholder-white/40 backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    @error('nis')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-slate-900 dark:text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Update
                    </button>
                    <a href="{{ route('siswa.index') }}"
                        class="rounded-lg border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-5 py-2 text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-8 rounded-2xl border border-red-400/20 bg-red-900/10 p-6 shadow-lg backdrop-blur-md">
            <h2 class="text-base font-semibold text-slate-900 dark:text-white mb-4">Reset Password Siswa</h2>
            <form action="{{ route('siswa.password.update', $siswa) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Password Baru</label>
                    <input type="password" id="password" name="password" required
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white placeholder-white/40 backdrop-blur-sm focus:border-red-400/50 focus:outline-none focus:ring-2 focus:ring-red-400/40">
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white placeholder-white/40 backdrop-blur-sm focus:border-red-400/50 focus:outline-none focus:ring-2 focus:ring-red-400/40">
                </div>
                <button type="submit"
                    class="rounded-lg bg-red-600 px-5 py-2 text-sm font-medium text-slate-900 dark:text-white shadow-md transition hover:bg-red-500">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</x-app-layout>