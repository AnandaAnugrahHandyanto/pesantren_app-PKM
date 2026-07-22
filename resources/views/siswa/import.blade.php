<x-app-layout>

    <div class="space-y-6">
        {{-- Pesan sukses/error --}}
        @if (session('success'))
            <div class="mb-4 rounded-xl border border-green-400/30 bg-green-500/20 px-4 py-3 text-sm text-green-200 backdrop-blur-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-red-400/30 bg-red-500/20 px-4 py-3 text-sm text-red-200 backdrop-blur-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Petunjuk --}}
        <div class="rounded-2xl border border-blue-400/30 bg-blue-500/10 px-5 py-4 shadow-lg backdrop-blur-md">
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <div class="text-sm text-blue-900 dark:text-blue-100/80">
                    <p class="font-medium text-blue-950 dark:text-blue-100">Petunjuk Import Data Siswa:</p>
                    <ol class="ml-4 mt-1 list-decimal space-y-0.5">
                        <li>Download template Excel terlebih dahulu.</li>
                        <li>Isi data siswa sesuai format template.</li>
                        <li>Kolom <strong class="text-slate-900 dark:text-white">Nama Lengkap</strong>, <strong class="text-slate-900 dark:text-white">Tingkat</strong>, <strong class="text-slate-900 dark:text-white">Rombel</strong>, dan <strong class="text-slate-900 dark:text-white">Jenis Kelamin</strong> wajib diisi.</li>
                        <li>NIS boleh dikosongkan (akan auto-generate).</li>
                        <li>Upload file <strong class="text-slate-900 dark:text-white">.xlsx</strong>, <strong class="text-slate-900 dark:text-white">.xls</strong>, atau <strong class="text-slate-900 dark:text-white">.csv</strong> (maks 5 MB).</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            {{-- Download Template --}}
            <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-6 shadow-lg backdrop-blur-md">
                <div class="flex h-full flex-col items-center justify-center gap-4 text-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500/20">
                        <svg class="h-8 w-8 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Download Template</h3>
                        <p class="mt-1 text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Template Excel dengan format kolom yang sudah sesuai.</p>
                    </div>
                    <a href="{{ route('siswa.template') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-emerald-500/20 px-5 py-2.5 text-sm font-medium text-emerald-800 dark:text-emerald-200 ring-1 ring-emerald-400/30 transition hover:bg-emerald-500/30 hover:text-emerald-900 dark:hover:text-emerald-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download Template
                    </a>
                </div>
            </div>

            {{-- Upload --}}
            <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-6 shadow-lg backdrop-blur-md">
                <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-4 text-center">
                    @csrf

                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-500/20">
                        <svg class="h-8 w-8 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Upload File</h3>
                        <p class="mt-1 text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Pilih file Excel yang sudah diisi.</p>
                    </div>

                    <div class="w-full">
                        <label for="file"
                            class="flex cursor-pointer flex-col items-center gap-2 rounded-xl border-2 border-dashed border-slate-300 dark:border-white/20 px-4 py-6 transition hover:border-indigo-400/50 hover:bg-white/[0.02]">
                            {{-- Placeholder --}}
                            <div id="file-instruction" class="flex flex-col items-center">
                                <svg class="h-10 w-10 text-slate-400 dark:text-white/30 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-sm text-slate-900 dark:text-slate-400 dark:text-white/40 text-center px-4">
                                    <span class="font-semibold text-indigo-400">Klik untuk memilih file Excel</span> atau drag & drop file di sini
                                </p>
                                <p class="mt-1 text-xs text-slate-500">Format: .xlsx • .xls • .csv</p>
                            </div>

                            {{-- Preview --}}
                            <div id="file-preview" class="hidden flex items-center justify-between w-full p-3 rounded-lg bg-indigo-900/20 border border-indigo-500/30">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <svg class="h-8 w-8 text-indigo-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <div class="overflow-hidden">
                                        <p id="file-name" class="text-sm font-bold text-white truncate"></p>
                                        <p id="file-size" class="text-xs text-indigo-300"></p>
                                    </div>
                                </div>
                                <button type="button" onclick="resetFile(event)" class="text-slate-400 hover:text-white">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </label>
                        <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv"
                            class="hidden">
                        @error('file')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="default_password" class="mb-1 block text-left text-xs font-medium text-slate-900 dark:text-slate-500 dark:text-white/60">Password Default</label>
                        <input type="text" id="default_password" name="default_password" value="{{ old('default_password') }}"
                            placeholder="Kosongkan jika tidak ingin buat akun"
                            class="w-full rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white placeholder-white/40 backdrop-blur-sm focus:border-blue-400/50 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                        <p class="mt-1 text-left text-xs text-slate-900 dark:text-white/30">Jika diisi, akun login akan otomatis dibuat untuk semua siswa yang diimport.</p>
                        @error('default_password')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-indigo-500 to-blue-600 px-5 py-2.5 text-sm font-medium text-slate-900 dark:text-white shadow-md transition hover:from-indigo-400 hover:to-blue-500 hover:shadow-lg">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Import Data
                    </button>
                </form>
            </div>
        </div>

        {{-- Hasil import terakhir --}}
        @if (session('import_results'))
            <div class="rounded-2xl border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 p-5 shadow-lg backdrop-blur-md">
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-500 dark:text-white/60">Hasil Import</h3>
                <div class="grid grid-cols-2 gap-4 text-center sm:grid-cols-4">
                    @foreach (session('import_results') as $key => $value)
                        <div class="rounded-xl border border-slate-200 dark:border-white/10 bg-white/[0.03] px-3 py-3">
                            <div class="text-lg font-bold
                                @switch($key)
                                    @case('success') text-green-300 @break
                                    @case('skipped') text-amber-300 @break
                                    @case('duplicates') text-rose-300 @break
                                    @default text-slate-900 dark:text-white
                                @endswitch
                            ">{{ $value }}</div>
                            <div class="mt-0.5 text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">
                                @switch($key)
                                    @case('success') Berhasil @break
                                    @case('skipped') Dilewati @break
                                    @case('duplicates') Duplikat @break
                                    @default {{ $key }}
                                @endswitch
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Tombol kembali --}}
        <div class="flex justify-start">
            <a href="{{ route('siswa.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2 text-sm font-medium text-slate-900 dark:text-slate-700 dark:text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Data Siswa
            </a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropZone = document.querySelector('label[for="file"]');
            const fileInput = document.getElementById('file');
            const fileInstruction = document.getElementById('file-instruction');
            const filePreview = document.getElementById('file-preview');
            const fileNameSpan = document.getElementById('file-name');
            const fileSizeSpan = document.getElementById('file-size');

            const handleFile = (files) => {
                if (files.length > 0) {
                    fileInput.files = files;
                    const file = files[0];
                    fileNameSpan.textContent = file.name;
                    
                    // Format size
                    const sizeInKB = file.size / 1024;
                    fileSizeSpan.textContent = sizeInKB >= 1024 
                        ? (sizeInKB / 1024).toFixed(2) + ' MB'
                        : Math.round(sizeInKB) + ' KB';

                    fileInstruction.classList.add('hidden');
                    filePreview.classList.remove('hidden');
                    dropZone.classList.remove('border-dashed', 'border-slate-300', 'dark:border-white/20');
                    dropZone.classList.add('border-solid', 'border-indigo-500/50');
                }
            };

            window.resetFile = function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.value = '';
                fileInstruction.classList.remove('hidden');
                filePreview.classList.add('hidden');
                dropZone.classList.add('border-dashed', 'border-slate-300', 'dark:border-white/20');
                dropZone.classList.remove('border-solid', 'border-indigo-500/50');
            };

            ['dragover', 'dragleave', 'drop'].forEach(event => {
                dropZone.addEventListener(event, (e) => {
                    e.preventDefault();
                    if (event === 'dragover') {
                        dropZone.classList.add('border-indigo-400', 'bg-indigo-500/10');
                    } else {
                        dropZone.classList.remove('border-indigo-400', 'bg-indigo-500/10');
                    }
                });
            });

            dropZone.addEventListener('drop', (e) => {
                handleFile(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', (e) => {
                handleFile(e.target.files);
            });
        });
    </script>
</x-app-layout>
