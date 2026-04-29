<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Import Data Santri</h1>
    </x-slot>

    <div class="mx-auto max-w-xl space-y-4">

        {{-- Format Guide Card --}}
        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <h2 class="mb-3 text-sm font-semibold text-white">Panduan Format File</h2>
            <p class="mb-3 text-sm text-white/60">
                Pastikan file Excel atau CSV memiliki header kolom berikut di baris pertama:
            </p>

            {{-- Example Table --}}
            <div class="mb-4 overflow-x-auto rounded-lg border border-white/10">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-white/70">nama_lengkap</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-white/70">kelas</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-white/70">jenis_kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        <tr class="hover:bg-white/[0.04]">
                            <td class="px-4 py-2 text-white/70">Ahmad</td>
                            <td class="px-4 py-2 text-white/70">7A</td>
                            <td class="px-4 py-2 text-white/70">Laki-laki</td>
                        </tr>
                        <tr class="hover:bg-white/[0.04]">
                            <td class="px-4 py-2 text-white/70">Ali</td>
                            <td class="px-4 py-2 text-white/70">7B</td>
                            <td class="px-4 py-2 text-white/70">Perempuan</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Notes --}}
            <ul class="space-y-1 text-sm text-white/60">
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 text-yellow-400">•</span>
                    <span>Header kolom harus sesuai persis: <span class="font-medium text-white/80">nama_lengkap, kelas, jenis_kelamin</span>.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 text-yellow-400">•</span>
                    <span>Kolom <span class="font-medium text-white/80">nama_lengkap</span> wajib diisi; baris dengan nilai kosong akan dilewati.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 text-yellow-400">•</span>
                    <span>Kolom <span class="font-medium text-white/80">jenis_kelamin</span> harus berisi <span class="font-medium text-white/80">Laki-laki</span> atau <span class="font-medium text-white/80">Perempuan</span>.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-0.5 text-yellow-400">•</span>
                    <span>Format file yang didukung: <span class="font-medium text-white/80">.xlsx</span> dan <span class="font-medium text-white/80">.csv</span>.</span>
                </li>
            </ul>

            {{-- Download Template Button --}}
            <div class="mt-4">
                <a href="{{ route('santri.template') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-emerald-400/40 bg-emerald-500/20 px-4 py-2 text-sm font-medium text-emerald-200 backdrop-blur-sm transition hover:bg-emerald-500/30 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    Download Template Excel
                </a>
            </div>
        </div>

        {{-- Upload Form Card --}}
        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">

            @if (session('success'))
                <div class="mb-4 rounded-xl border border-green-400/30 bg-green-500/20 px-4 py-3 text-sm text-green-200 backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('santri.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="file" class="mb-1 block text-sm font-medium text-white/80">
                        File Excel / CSV <span aria-hidden="true">*</span>
                    </label>
                    <input type="file" id="file" name="file" accept=".xlsx,.csv" required aria-required="true"
                        class="w-full rounded-lg border border-white/30 bg-white/10 px-3 py-2 text-sm text-white file:mr-3 file:cursor-pointer file:rounded-md file:border-0 file:bg-blue-500/70 file:px-3 file:py-1 file:text-xs file:font-medium file:text-white backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    @error('file')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-md transition hover:from-blue-400 hover:to-indigo-500 hover:shadow-lg">
                        Import
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
