<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Edit Absensi</h1>
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

        <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('absensi.update', $absensi) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="mata_pelajaran_id" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Mata Pelajaran <span aria-hidden="true">*</span></label>
                    <select id="mata_pelajaran_id" name="mata_pelajaran_id" required
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        @foreach ($mataPelajaranOptions as $mp)
                            <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id', $absensi->mata_pelajaran_id) == $mp->id ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">
                                {{ $mp->nama }} (Kelas {{ $mp->kelas }})
                            </option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran_id')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="siswa_id" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Siswa <span aria-hidden="true">*</span></label>
                    <select id="siswa_id" name="siswa_id" required aria-label="Pilih siswa"
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="" disabled class="bg-indigo-950 text-slate-900 dark:text-white">Pilih siswa</option>
                        @foreach ($siswas as $siswa)
                            <option value="{{ $siswa->id }}"
                                {{ old('siswa_id', $absensi->siswa_id) == $siswa->id ? 'selected' : '' }}
                                class="bg-indigo-950 text-slate-900 dark:text-white">
                                {{ $siswa->nis }} – {{ $siswa->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Tanggal <span aria-hidden="true">*</span></label>
                    <input type="date" id="tanggal" name="tanggal"
                        value="{{ old('tanggal', $absensi->tanggal->toDateString()) }}"
                        required
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    @error('tanggal')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80">Status <span aria-hidden="true">*</span></label>
                    <select id="status" name="status" required
                        class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="" disabled class="bg-indigo-950 text-slate-900 dark:text-white">Pilih status</option>
                        <option value="hadir" {{ old('status', $absensi->status) === 'hadir' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Hadir</option>
                        <option value="izin"  {{ old('status', $absensi->status) === 'izin'  ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Izin</option>
                        <option value="sakit" {{ old('status', $absensi->status) === 'sakit' ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Sakit</option>
                        <option value="alfa"  {{ old('status', $absensi->status) === 'alfa'  ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Alfa</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-slate-900 dark:text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Update
                    </button>
                    <a href="{{ route('absensi.index', ['tanggal' => $absensi->tanggal->toDateString(), 'mata_pelajaran_id' => $absensi->mata_pelajaran_id]) }}"
                        class="rounded-lg border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-5 py-2 text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>