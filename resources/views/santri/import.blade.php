<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Import Data Santri</h1>
    </x-slot>

    <div class="mx-auto max-w-xl">
        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">

            @if (session('success'))
                <div class="mb-4 rounded-xl border border-green-400/30 bg-green-500/20 px-4 py-3 text-sm text-green-200 backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            <p class="mb-4 text-sm text-white/60">
                Upload file Excel (.xlsx) atau CSV (.csv) dengan kolom: <span class="font-medium text-white/80">nama, nis, kelas, alamat</span>.
                Data dengan NIS yang sudah ada akan dilewati.
            </p>

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
