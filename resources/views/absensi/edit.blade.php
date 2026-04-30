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

        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('absensi.update', $absensi) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="kategori" class="mb-1 block text-sm font-medium text-white/80">Kategori</label>
                    <select id="kategori" name="kategori" required
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="sekolah"  {{ old('kategori', $absensi->kategori) === 'sekolah'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Sekolah</option>
                        <option value="halaqoh"  {{ old('kategori', $absensi->kategori) === 'halaqoh'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Halaqoh</option>
                        <option value="berkebun" {{ old('kategori', $absensi->kategori) === 'berkebun' ? 'selected' : '' }} class="bg-indigo-950 text-white">Berkebun</option>
                        <option value="dirosah"  {{ old('kategori', $absensi->kategori) === 'dirosah'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Dirosah</option>
                    </select>
                </div>

                <div>
                    <label for="santri_id" class="mb-1 block text-sm font-medium text-white/80">Santri</label>
                    <select id="santri_id" name="santri_id" required aria-label="Pilih santri"
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="" disabled class="bg-indigo-950 text-white">Pilih santri</option>
                        @foreach ($santris as $santri)
                            <option value="{{ $santri->id }}"
                                {{ old('santri_id', $absensi->santri_id) == $santri->id ? 'selected' : '' }}
                                class="bg-indigo-950 text-white">
                                {{ $santri->nis }} – {{ $santri->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tanggal" class="mb-1 block text-sm font-medium text-white/80">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal"
                        value="{{ old('tanggal', $absensi->tanggal->toDateString()) }}"
                        required
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                </div>

                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-white/80">Status</label>
                    <select id="status" name="status" required
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <option value="" disabled class="bg-indigo-950 text-white">Pilih status</option>
                        <option value="hadir" {{ old('status', $absensi->status) === 'hadir' ? 'selected' : '' }} class="bg-indigo-950 text-white">Hadir</option>
                        <option value="izin"  {{ old('status', $absensi->status) === 'izin'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Izin</option>
                        <option value="sakit" {{ old('status', $absensi->status) === 'sakit' ? 'selected' : '' }} class="bg-indigo-950 text-white">Sakit</option>
                        <option value="alfa"  {{ old('status', $absensi->status) === 'alfa'  ? 'selected' : '' }} class="bg-indigo-950 text-white">Alfa</option>
                    </select>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Update
                    </button>
                    <a href="{{ route('absensi.index', ['tanggal' => $absensi->tanggal->toDateString(), 'kategori' => $absensi->kategori]) }}"
                        class="rounded-lg border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
