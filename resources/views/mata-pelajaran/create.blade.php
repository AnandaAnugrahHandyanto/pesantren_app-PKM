<x-app-layout>

    <div class="mx-auto max-w-lg">
        <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form method="POST" action="{{ route('mata-pelajaran.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="nama" class="mb-1 block text-sm font-medium text-slate-900 dark:text-white/80">Nama Mata Pelajaran <span class="text-red-400">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                           placeholder="Contoh: Matematika, Bahasa Indonesia, IPA"
                           class="w-full rounded-xl border border-slate-300 dark:border-white/20 bg-white/[0.06] px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-white/30 backdrop-blur-sm transition focus:border-indigo-400/50 focus:outline-none focus:ring-2 focus:ring-indigo-400/20">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="guru_id" class="mb-1 block text-sm font-medium text-slate-900 dark:text-white/80">Guru Pengajar <span class="text-red-400">*</span></label>
                    <select name="guru_id" id="guru_id" required
                            class="w-full appearance-none rounded-xl border border-slate-300 dark:border-white/20 bg-white/[0.06] px-4 py-2.5 pr-10 text-sm text-slate-900 dark:text-white backdrop-blur-sm transition focus:border-indigo-400/50 focus:outline-none focus:ring-2 focus:ring-indigo-400/20">
                        <option value="" disabled class="bg-slate-900 text-slate-900 dark:text-white" {{ !old('guru_id') ? 'selected' : '' }}>Pilih guru</option>
                        @foreach (\App\Models\Guru::orderBy('nama_lengkap')->get() as $guru)
                            <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }} class="bg-slate-900 text-slate-900 dark:text-white">
                                {{ $guru->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('guru_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kelas" class="mb-1 block text-sm font-medium text-slate-900 dark:text-white/80">Kelas <span class="text-red-400">*</span></label>
                    <select name="kelas_v2" id="kelas" required
                            class="w-full appearance-none rounded-xl border border-slate-300 dark:border-white/20 bg-white/[0.06] px-4 py-2.5 pr-10 text-sm text-slate-900 dark:text-white backdrop-blur-sm transition focus:border-indigo-400/50 focus:outline-none focus:ring-2 focus:ring-indigo-400/20">
                        <option value="" disabled class="bg-slate-900 text-slate-900 dark:text-white" {{ !old('kelas') ? 'selected' : '' }}>Pilih kelas</option>
                        @foreach ([7, 8, 9] as $k)
                            <option value="{{ $k }}" {{ old('kelas') == $k ? 'selected' : '' }} class="bg-slate-900 text-slate-900 dark:text-white">
                                Kelas {{ $k }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rombel" class="mb-1 block text-sm font-medium text-slate-900 dark:text-white/80">Rombel <span class="text-red-400">*</span></label>
                    <select name="rombel" id="rombel" required
                            class="w-full appearance-none rounded-xl border border-slate-300 dark:border-white/20 bg-white/[0.06] px-4 py-2.5 pr-10 text-sm text-slate-900 dark:text-white backdrop-blur-sm transition focus:border-indigo-400/50 focus:outline-none focus:ring-2 focus:ring-indigo-400/20">
                        <option value="" disabled class="bg-slate-900 text-slate-900 dark:text-white" {{ !old('rombel') ? 'selected' : '' }}>Pilih rombel</option>
                        @foreach (['A', 'B', 'C', 'D', 'E'] as $r)
                            <option value="{{ $r }}" {{ old('rombel') == $r ? 'selected' : '' }} class="bg-slate-900 text-slate-900 dark:text-white">
                                {{ $r }}
                            </option>
                        @endforeach
                    </select>
                    @error('rombel')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="rounded-xl bg-gradient-to-r from-indigo-500/90 to-blue-600/90 px-6 py-2.5 text-sm font-semibold text-slate-900 dark:text-white shadow-lg shadow-indigo-500/20 transition hover:from-indigo-400 hover:to-blue-500">
                        Simpan
                    </button>
                    <a href="{{ route('mata-pelajaran.index') }}"
                       class="rounded-xl border border-slate-300 dark:border-white/20 px-6 py-2.5 text-sm text-slate-900 dark:text-slate-600 dark:text-white/70 transition hover:bg-slate-50 dark:bg-white/10 hover:text-slate-900 dark:text-white">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
