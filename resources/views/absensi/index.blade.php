<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Absensi Massal Siswa</h1>
    </x-slot>

    @php
        $statusLabels = [
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alfa' => 'Alfa',
        ];

        $statusTooltips = [
            'hadir' => 'Hadir - Sukses/Valid',
            'izin' => 'Izin - Menunggu/Persetujuan',
            'sakit' => 'Sakit - Kondisi Kesehatan',
            'alfa' => 'Alfa - Tidak Hadir Tanpa Keterangan',
        ];
    @endphp

    <div class="space-y-5">
        @if ($errors->any())
            <div class="rounded-xl border border-red-400/30 bg-red-500/20 px-4 py-3 text-sm text-red-100 backdrop-blur-sm">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($allAbsensiComplete)
            <div class="rounded-xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm font-semibold text-emerald-800 dark:text-emerald-100 backdrop-blur-sm">
                Semua absensi untuk mata pelajaran ini sudah lengkap.
            </div>
        @endif

        <form method="GET" action="{{ route('absensi.index') }}" class="glass-panel rounded-2xl p-4 sm:p-5">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label for="tanggal_filter" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-900 dark:text-white/75">Tanggal</label>
                    <input id="tanggal_filter" type="date" name="tanggal" value="{{ $tanggal }}"
                        class="w-full rounded-lg border border-white/25 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                </div>
                <div>
                    <label for="mata_pelajaran_filter" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-900 dark:text-white/75">Mata Pelajaran <span class="text-red-400">*</span></label>
                    <select id="mata_pelajaran_filter" name="mata_pelajaran_id" required
                        class="w-full rounded-lg border border-white/25 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                        <option value="" class="bg-indigo-950 text-slate-900 dark:text-white" disabled {{ !$mataPelajaranId ? 'selected' : '' }}>Pilih Mata Pelajaran</option>
                        @foreach ($mataPelajaranOptions as $mp)
                            <option value="{{ $mp->id }}" @selected($mataPelajaranId == $mp->id) class="bg-indigo-950 text-slate-900 dark:text-white">
                                {{ $mp->nama }} (Kelas {{ $mp->kelas_v2 }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="kelas_filter" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-900 dark:text-slate-600 dark:text-white/70">Pilih Kelas</label>
                    <select id="kelas_filter" name="kelas_v2" required
                        class="w-full rounded-lg border border-white/25 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                        <option value="" class="bg-indigo-950 text-slate-900 dark:text-white" disabled {{ !$kelas_v2 ? 'selected' : '' }}>Pilih Kelas</option>
                        @foreach ($kelasOptions as $k)
                            <option value="{{ $k }}" {{ $kelas_v2 == $k ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="rombel_filter" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-900 dark:text-slate-600 dark:text-white/70">Pilih Rombel</label>
                    <select id="rombel_filter" name="rombel" required
                        class="w-full rounded-lg border border-white/25 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                        <option value="" class="bg-indigo-950 text-slate-900 dark:text-white" disabled {{ !$rombel ? 'selected' : '' }}>Pilih Rombel</option>
                        @foreach ($rombelOptions as $r)
                            <option value="{{ $r }}" {{ $rombel == $r ? 'selected' : '' }} class="bg-indigo-950 text-slate-900 dark:text-white">Rombel {{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="search_siswa" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-900 dark:text-white/75">Cari Siswa</label>
                    <input id="search_siswa" type="text" placeholder="Ketik nama siswa..."
                        class="w-full rounded-lg border border-white/25 bg-slate-50 dark:bg-white/10 px-3 py-2 text-sm text-slate-900 dark:text-white placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                </div>
            </div>

            {{-- Action Bar --}}
            <div class="mt-4 flex flex-wrap items-center gap-2 sm:gap-3">
                <button type="submit"
                    class="rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-4 py-2 text-sm font-semibold text-slate-800 dark:text-white transition hover:bg-white/20">
                    Tampilkan Data
                </button>
                @if ($hasExistingAbsensi)
                    <span class="rounded-full border border-orange-400/40 bg-orange-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-orange-800 dark:text-orange-100">
                        Absensi Sudah Ada ({{ $existingCount }} data)
                    </span>
                @endif
                <button type="button" id="btn-hadir-semua"
                    class="rounded-lg border border-emerald-400/50 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-800 dark:text-emerald-200 transition hover:bg-emerald-500/20">
                    Hadir Semua
                </button>
                <button type="button" id="btn-isi-alfa"
                    class="rounded-lg border border-rose-400/40 bg-rose-500/10 px-4 py-2 text-sm font-semibold text-rose-800 dark:text-rose-100 transition hover:bg-rose-500/20">
                    Isi Belum Absen Menjadi Alfa
                </button>
                <button type="button" id="btn-reset-absensi"
                    class="rounded-lg border border-slate-400 dark:border-white/30 bg-slate-50 dark:bg-white/10 px-4 py-2 text-sm font-semibold text-slate-800 dark:text-slate-800 dark:text-white/90 transition hover:bg-slate-200 dark:hover:bg-white/20">
                    Reset Absensi
                </button>
                <span id="visible-counter" class="ms-auto text-xs font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">
                    0 / {{ $siswas->count() }} siswa tampil
                </span>
            </div>
        </form>

        <form method="POST" action="{{ route('absensi.mass-store') }}" id="mass-absensi-form" class="glass-panel rounded-2xl">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="mata_pelajaran_id" value="{{ $mataPelajaranId }}">
            <input type="hidden" name="form_mode" value="{{ $absensiMode }}">

            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 dark:border-white/15 px-4 py-3 sm:px-5">
                <div class="flex flex-wrap items-center gap-2 text-sm text-slate-900 dark:text-white/75">
                    <span>{{ $absensiMode === 'edit' ? 'Edit status lalu klik' : 'Isi status lalu klik' }} <span
                            class="font-semibold text-slate-900 dark:text-white">{{ $absensiMode === 'edit' ? 'Update Absensi' : 'Simpan Absensi' }}</span></span>
                    <span id="draft-state-badge"
                        class="rounded-full border px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-800 dark:text-slate-200">
                    </span>
                    <span id="filled-counter" class="text-xs font-semibold text-slate-900 dark:text-slate-600 dark:text-white/70"></span>
                </div>
                <button type="submit"
                    id="btn-simpan-absensi"
                    class="w-full whitespace-nowrap rounded-lg bg-gradient-to-r from-cyan-500/90 to-blue-600/90 px-4 py-2 text-sm font-semibold text-slate-900 dark:text-white shadow-lg shadow-cyan-500/20 transition hover:from-cyan-400 hover:to-blue-500 sm:w-auto">
                    {{ $absensiMode === 'edit' ? 'Update Absensi' : 'Simpan Absensi' }}
                </button>
            </div>

            <div class="grid gap-2 border-b border-slate-200 dark:border-white/10 px-4 py-3 text-xs text-slate-900 dark:text-white/75 sm:grid-cols-2 lg:grid-cols-5 sm:px-5">
                <div><span class="text-slate-900 dark:text-white/55">Mata Pelajaran:</span> <span class="font-semibold text-slate-900 dark:text-white">{{ $selectedMataPelajaran?->nama ?? '-' }} (Kelas {{ $selectedMataPelajaran?->kelas_v2 ?? '-' }})</span></div>
                <div><span class="text-slate-900 dark:text-white/55">Tanggal aktif:</span> <span class="font-semibold text-slate-900 dark:text-white">{{ $tanggal }}</span></div>
                <div><span class="text-slate-900 dark:text-white/55">Jumlah siswa:</span> <span class="font-semibold text-slate-900 dark:text-white">{{ $totalSiswa }}</span></div>
                <div><span class="text-slate-900 dark:text-white/55">Sudah diabsen:</span> <span class="font-semibold text-slate-900 dark:text-white" id="existing-count">{{ $existingCount }}</span></div>
                <div><span class="text-slate-900 dark:text-white/55">Terakhir diupdate:</span> <span class="font-semibold text-slate-900 dark:text-white">{{ $lastUpdatedAt ? \Illuminate\Support\Carbon::parse($lastUpdatedAt)->format('d-m-Y H:i') : '-' }}</span></div>
            </div>

            {{-- Status Breakdown --}}
            <div class="grid grid-cols-2 gap-2 border-b border-slate-200 dark:border-white/10 px-4 py-3 sm:grid-cols-4 sm:px-5">
                <div class="flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-xs">
                    <svg class="h-3 w-3 flex-shrink-0 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <div>
                        <span class="text-slate-900 dark:text-white/55">Hadir</span>
                        <span class="ml-1 font-bold text-emerald-300" id="count-hadir">{{ $statusCounts['hadir'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 rounded-lg border border-amber-500/20 bg-amber-500/10 px-3 py-2 text-xs">
                    <svg class="h-3 w-3 flex-shrink-0 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <div>
                        <span class="text-slate-900 dark:text-white/55">Izin</span>
                        <span class="ml-1 font-bold text-amber-300" id="count-izin">{{ $statusCounts['izin'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 rounded-lg border border-violet-500/20 bg-violet-500/10 px-3 py-2 text-xs">
                    <svg class="h-3 w-3 flex-shrink-0 text-violet-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <div>
                        <span class="text-slate-900 dark:text-white/55">Sakit</span>
                        <span class="ml-1 font-bold text-violet-300" id="count-sakit">{{ $statusCounts['sakit'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 rounded-lg border border-red-500/20 bg-red-500/10 px-3 py-2 text-xs">
                    <svg class="h-3 w-3 flex-shrink-0 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div>
                        <span class="text-slate-900 dark:text-white/55">Alfa</span>
                        <span class="ml-1 font-bold text-red-300" id="count-alfa">{{ $statusCounts['alfa'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="table-scroll-wrapper">
                <table class="min-w-full table-fixed">
                    <thead class="table-header-sticky bg-slate-50 dark:bg-white/10 backdrop-blur-sm">
                        <tr class="border-b border-slate-200 dark:border-white/10">
                            <th class="w-10 px-2 py-2.5 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-900 dark:text-white/75 sm:w-16 sm:px-3 sm:py-3 sm:text-xs">No</th>
                            <th class="px-2 py-2.5 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-900 dark:text-white/75 sm:px-3 sm:py-3 sm:text-xs">Nama Lengkap</th>
                            <th class="w-20 px-2 py-2.5 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-900 dark:text-white/75 sm:w-32 sm:px-3 sm:py-3 sm:text-xs">Kelas</th>
                            <th class="hidden px-2 py-2.5 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-900 dark:text-white/75 sm:table-cell sm:w-36 sm:px-3 sm:py-3 sm:text-xs">Jenis Kelamin</th>
                            <th class="w-auto px-2 py-2.5 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-900 dark:text-white/75 sm:w-[22rem] sm:px-3 sm:py-3 sm:text-xs">Status Absensi</th>
                        </tr>
                    </thead>
                    <tbody id="absensi-tbody" class="divide-y divide-white/10">
                        @forelse ($siswas as $index => $siswa)
                            @php
                                $existingStatus = $statusBySiswa[$siswa->id] ?? '';
                                $initialStatus = old("absensi.{$siswa->id}", $absensiMode === 'edit' ? $existingStatus : '');
                            @endphp
                            <tr class="attendance-row border-l-[3px] border-transparent transition duration-200 hover:bg-white/[0.03]"
                                data-siswa-row
                                data-name="{{ strtolower($siswa->nama_lengkap) }}"
                                data-kelas="{{ strtolower($siswa->kelas_v2 ?? '-') }}"
                                data-row-id="{{ $siswa->id }}"
                                data-existing-status="{{ $existingStatus }}"
                                data-initial-status="{{ $initialStatus }}">
                                <td class="px-2 py-2 text-sm text-slate-900 dark:text-white/70 sm:px-3 sm:py-2.5">{{ $index + 1 }}</td>
                                <td class="px-2 py-2 text-sm font-medium text-slate-900 dark:text-white sm:px-3 sm:py-2.5">
                                    <span>{{ $siswa->nama_lengkap }}</span>
                                </td>
                                <td class="px-2 py-2 text-sm text-slate-900 dark:text-slate-700 dark:text-white/80 sm:px-3 sm:py-2.5">@if($siswa->kelas_v2 && $siswa->rombel)
                                    {{ $siswa->kelas_v2 }}{{ $siswa->rombel }}
                                @else
                                    -
                                @endif</td>
                                <td class="hidden px-2 py-2 text-sm text-slate-900 dark:text-slate-700 dark:text-white/80 sm:table-cell sm:px-3 sm:py-2.5">
                                    @if (($siswa->jenis_kelamin ?? '') === 'L')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-cyan-400/30 bg-cyan-500/20 px-2.5 py-0.5 text-[11px] font-semibold text-cyan-200 shadow-sm">
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="5" r="3.5"/><path d="M12 8.5v10M8 14h8"/>
                                            </svg>
                                            Laki-laki
                                        </span>
                                    @elseif (($siswa->jenis_kelamin ?? '') === 'P')
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-pink-400/30 bg-pink-500/20 px-2.5 py-0.5 text-[11px] font-semibold text-pink-200 shadow-sm">
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="5" r="3.5"/><path d="M12 8.5v6M8 11h8"/>
                                            </svg>
                                            Perempuan
                                        </span>
                                    @else
                                        <span class="text-slate-900 dark:text-slate-500 dark:text-white/50">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 sm:px-3 sm:py-2.5">
                                    <input type="hidden" name="absensi[{{ $siswa->id }}]" value="{{ $initialStatus }}" data-status-input>
                                    <div class="grid grid-cols-2 gap-1 sm:grid-cols-4 sm:gap-1.5">
                                        @foreach ($statusOptions as $statusOption)
                                            <button type="button"
                                                data-status-btn="{{ $statusOption }}"
                                                title="{{ $statusTooltips[$statusOption] }}"
                                                class="status-btn">
                                                <x-status-icon :status="$statusOption" class="h-3 w-3 shrink-0 sm:h-3.5 sm:w-3.5" />
                                                <span class="text-[10px] leading-none sm:text-[11px]">{{ $statusLabels[$statusOption] }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-slate-900 dark:text-white/55">
                                    Data siswa belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (!window.Swal) {
                    console.warn('SweetAlert2 gagal dimuat untuk toast notifikasi.');
                    return;
                }

                window.Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: @js(session('success')),
                    showConfirmButton: false,
                    timer: 2300,
                    timerProgressBar: true,
                    background: '#0f172acc',
                    color: '#e2e8f0',
                });
            });
        </script>
    @endif

    @if (session('absensi_exists_warning'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (!window.Swal) {
                    return;
                }

                const warning = @json(session('absensi_exists_warning'));
                window.Swal.fire({
                    icon: 'warning',
                    title: 'Absensi Sudah Ada',
                    text: `Absensi untuk mata pelajaran tersebut pada tanggal ${warning.tanggal} sudah pernah dilakukan. Silakan gunakan mode edit untuk memperbarui data.`,
                    background: '#0f172acc',
                    color: '#e2e8f0',
                    confirmButtonText: 'Mengerti',
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rows = Array.from(document.querySelectorAll('[data-siswa-row]'));
            const kelasFilter = document.getElementById('kelas_filter');
            const searchInput = document.getElementById('search_siswa');
            const visibleCounter = document.getElementById('visible-counter');
            const filledCounter = document.getElementById('filled-counter');
            const draftStateBadge = document.getElementById('draft-state-badge');
            const hadirSemuaBtn = document.getElementById('btn-hadir-semua');
            const isiAlfaBtn = document.getElementById('btn-isi-alfa');
            const resetAbsensiBtn = document.getElementById('btn-reset-absensi');
            const submitBtn = document.getElementById('btn-simpan-absensi');
            const form = document.getElementById('mass-absensi-form');
            const totalRows = rows.length;
            const tanggal = form.querySelector('input[name="tanggal"]').value;
            const mataPelajaranId = form.querySelector('input[name="mata_pelajaran_id"]').value;
            const formMode = form.querySelector('input[name="form_mode"]').value;
            const isEditMode = formMode === 'edit';
            const storageKey = `absensi-draft:${tanggal}:${mataPelajaranId}`;
            const hasSaveSuccess = @js((bool) session('success'));
            const hasValidationErrors = @js($errors->any());
            const defaultButtonClass = 'status-btn';
            const changedFlashClass = ['bg-orange-500/10'];

            const rowStatusClasses = {
                hadir: ['status-row-hadir'],
                izin: ['status-row-izin'],
                sakit: ['status-row-sakit'],
                alfa: ['status-row-alfa'],
            };

            const badgeClasses = {
                hadir: 'status-btn-hadir-active',
                izin: 'status-btn-izin-active',
                sakit: 'status-btn-sakit-active',
                alfa: 'status-btn-alfa-active',
            };

            const normalize = (value) => (value || '').toLowerCase().trim();
            const isAllHadir = () => rows.every((row) => row.querySelector('[data-status-input]').value === 'hadir');
            const getFilledCount = () => rows.filter((row) => row.querySelector('[data-status-input]').value).length;

            const clearDraft = () => localStorage.removeItem(storageKey);

            const updateStatusCounts = () => {
                const counts = { hadir: 0, izin: 0, sakit: 0, alfa: 0 };
                rows.forEach((row) => {
                    const val = row.querySelector('[data-status-input]').value;
                    if (counts.hasOwnProperty(val)) counts[val]++;
                });
                document.getElementById('count-hadir').textContent = counts.hadir;
                document.getElementById('count-izin').textContent = counts.izin;
                document.getElementById('count-sakit').textContent = counts.sakit;
                document.getElementById('count-alfa').textContent = counts.alfa;
                document.getElementById('existing-count').textContent = getFilledCount();
            };

            const setDraftBadgeState = (state) => {
                draftStateBadge.className = 'rounded-full border px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-800 dark:text-slate-200';
                if (state === 'saved') {
                    draftStateBadge.classList.add('border-emerald-400/40', 'bg-emerald-500/10', 'text-emerald-800', 'dark:text-emerald-100');
                    draftStateBadge.textContent = 'Data tersimpan di database';
                    return;
                }

                draftStateBadge.classList.add('border-orange-400/40', 'bg-orange-500/10', 'text-orange-800', 'dark:text-orange-100');
                draftStateBadge.textContent = 'Draft belum disimpan';
            };

            const updateSubmitState = () => {
                const filledCount = getFilledCount();
                const allFilled = totalRows > 0 && filledCount === totalRows;
                submitBtn.disabled = !allFilled;
                submitBtn.classList.toggle('opacity-50', !allFilled);
                submitBtn.classList.toggle('cursor-not-allowed', !allFilled);
                filledCounter.textContent = `${filledCount} / ${totalRows} siswa sudah diabsen`;
            };

            const syncMassButtonText = () => {
                const allHadir = isAllHadir() && getFilledCount() === totalRows && totalRows > 0;
                hadirSemuaBtn.textContent = allHadir ? 'Batalkan Hadir Semua' : 'Hadir Semua';
                hadirSemuaBtn.className = allHadir
                    ? 'rounded-lg border border-slate-400/50 bg-slate-500/10 px-4 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 transition hover:bg-slate-500/20'
                    : 'rounded-lg border border-emerald-400/50 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-800 dark:text-emerald-200 transition hover:bg-emerald-500/20';
            };

            const saveDraft = () => {
                const payload = {};
                rows.forEach((row) => {
                    const id = row.dataset.rowId;
                    const input = row.querySelector('[data-status-input]');
                    payload[id] = input.value || '';
                });
                localStorage.setItem(storageKey, JSON.stringify(payload));
                setDraftBadgeState('draft');
            };

            const flashEditedRow = (row) => {
                row.classList.add(...changedFlashClass);
                window.setTimeout(() => {
                    row.classList.remove(...changedFlashClass);
                }, 900);
            };

            const updateRowVisual = (row, status) => {
                row.classList.remove(
                    'status-row-hadir',
                    'status-row-izin',
                    'status-row-sakit',
                    'status-row-alfa'
                );

                if (rowStatusClasses[status]) {
                    row.classList.add(...rowStatusClasses[status]);
                }

                const buttons = row.querySelectorAll('[data-status-btn]');
                buttons.forEach((button) => {
                    button.className = defaultButtonClass;
                    if (button.dataset.statusBtn === status) {
                        button.className = `${defaultButtonClass} ${badgeClasses[status]}`;
                    }
                });
                row.querySelectorAll('[data-status-btn]').forEach(btn => btn.blur());
            };

            const setStatus = (row, status, options = {
                persistDraft: true,
                markDraft: true,
                flashIfChanged: false,
            }) => {
                const input = row.querySelector('[data-status-input]');
                input.value = status;
                updateRowVisual(row, status);

                if (options.flashIfChanged && isEditMode && row.dataset.existingStatus !== status) {
                    flashEditedRow(row);
                }

                updateSubmitState();
                syncMassButtonText();
                updateStatusCounts();

                if (options.markDraft) {
                    setDraftBadgeState('draft');
                }

                if (options.persistDraft) {
                    saveDraft();
                }
            };

            const applyFilter = () => {
                const selectedKelas = normalize(kelasFilter.value);
                const keyword = normalize(searchInput.value);
                let visible = 0;

                rows.forEach((row) => {
                    const rowKelas = normalize(row.dataset.kelas);
                    const rowName = normalize(row.dataset.name);
                    const passKelas = !selectedKelas || rowKelas === selectedKelas;
                    const passName = !keyword || rowName.includes(keyword);
                    const show = passKelas && passName;
                    row.classList.toggle('hidden', !show);
                    if (show) visible++;
                });

                visibleCounter.textContent = `${visible} / ${rows.length} siswa tampil`;
            };

            const resetAllStatuses = (markDraft = true) => {
                rows.forEach((row) => {
                    setStatus(row, '', { persistDraft: false, markDraft: false, flashIfChanged: false });
                });
                clearDraft();
                syncMassButtonText();
                updateSubmitState();
                if (markDraft) {
                    setDraftBadgeState('draft');
                } else {
                    setDraftBadgeState('saved');
                }
            };

            const restoreDraft = () => {
                const raw = localStorage.getItem(storageKey);
                if (!raw) {
                    return;
                }

                try {
                    const draft = JSON.parse(raw);
                    rows.forEach((row) => {
                        const rowId = row.dataset.rowId;
                        const status = draft[rowId] || '';
                        setStatus(row, status, { persistDraft: false, markDraft: false, flashIfChanged: false });
                    });
                    setDraftBadgeState('draft');
                } catch (error) {
                    console.warn('Draft absensi rusak dan telah dibersihkan.', error);
                    clearDraft();
                }
            };

            rows.forEach((row) => {
                const input = row.querySelector('[data-status-input]');
                updateRowVisual(row, input.value || '');
                row.querySelectorAll('[data-status-btn]').forEach((button) => {
                    button.addEventListener('click', () => {
                        const status = button.dataset.statusBtn;
                        setStatus(row, status, { flashIfChanged: true });
                    });
                });
            });

            hadirSemuaBtn?.addEventListener('click', () => {
                const currentlyAllHadir = isAllHadir() && getFilledCount() === totalRows && totalRows > 0;
                const message = currentlyAllHadir
                    ? 'Semua status siswa akan dikosongkan. Data yang sudah tersimpan di database tidak akan berubah sampai kamu menyimpan ulang.'
                    : 'Semua status siswa yang tampil akan diisi menjadi <strong>Hadir</strong>.';

                Swal.fire({
                    title: currentlyAllHadir ? 'Batalkan Hadir Semua?' : 'Hadirkan Semua?',
                    html: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: currentlyAllHadir ? 'Ya, Kosongkan' : 'Ya, Hadirkan Semua',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: currentlyAllHadir ? '#64748b' : '#10b981',
                    cancelButtonColor: '#6b7280',
                    background: '#1e1b4b',
                    color: '#e2e8f0',
                    iconColor: '#60a5fa',
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    if (currentlyAllHadir) {
                        resetAllStatuses(true);
                        return;
                    }

                    rows.forEach((row) => {
                        setStatus(row, 'hadir', { persistDraft: false, markDraft: false, flashIfChanged: true });
                    });
                    saveDraft();
                    syncMassButtonText();
                    updateSubmitState();
                    setDraftBadgeState('draft');
                });
            });

            isiAlfaBtn?.addEventListener('click', () => {
                const emptyCount = rows.filter((row) => !row.querySelector('[data-status-input]').value).length;
                if (emptyCount === 0) {
                    Swal.fire({
                        title: 'Tidak Ada Perubahan',
                        text: 'Semua siswa sudah memiliki status. Tidak ada yang perlu diisi Alfa.',
                        icon: 'info',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#6b7280',
                        background: '#1e1b4b',
                        color: '#e2e8f0',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Isi Alfa?',
                    html: `<strong>${emptyCount}</strong> siswa yang belum diabsen akan diisi <strong>Alfa</strong>.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Isi Alfa',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#f43f5e',
                    cancelButtonColor: '#6b7280',
                    background: '#1e1b4b',
                    color: '#e2e8f0',
                    iconColor: '#f43f5e',
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    rows.forEach((row) => {
                        const input = row.querySelector('[data-status-input]');
                        if (!input.value) {
                            setStatus(row, 'alfa', { persistDraft: false, markDraft: false, flashIfChanged: true });
                        }
                    });
                    saveDraft();
                    syncMassButtonText();
                    updateSubmitState();
                    setDraftBadgeState('draft');
                });
            });

            resetAbsensiBtn?.addEventListener('click', () => {
                Swal.fire({
                    title: 'Reset Absensi?',
                    text: 'Semua status siswa akan dikosongkan. Data yang sudah tersimpan di database tidak terpengaruh sampai kamu menyimpan ulang.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Reset',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    background: '#1e1b4b',
                    color: '#e2e8f0',
                    iconColor: '#f43f5e',
                }).then((result) => {
                    if (result.isConfirmed) {
                        resetAllStatuses(true);
                    }
                });
            });

            form?.addEventListener('submit', (e) => {
                const filledCount = getFilledCount();
                if (filledCount === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Belum Ada Data',
                        text: 'Isi status absensi terlebih dahulu sebelum menyimpan.',
                        icon: 'info',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#6b7280',
                        background: '#1e1b4b',
                        color: '#e2e8f0',
                    });
                    return;
                }

                e.preventDefault();
                const mode = isEditMode ? 'Update' : 'Simpan';
                Swal.fire({
                    title: isEditMode ? 'Update Absensi?' : 'Simpan Absensi?',
                    html: `<strong>${filledCount}</strong> dari <strong>${totalRows}</strong> siswa akan disimpan.<br>Data yang sudah ada akan ditimpa.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: isEditMode ? 'Ya, Update' : 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#06b6d4',
                    cancelButtonColor: '#6b7280',
                    background: '#1e1b4b',
                    color: '#e2e8f0',
                    iconColor: '#60a5fa',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
            kelasFilter?.addEventListener('change', applyFilter);
            searchInput?.addEventListener('input', applyFilter);
            syncMassButtonText();
            updateStatusCounts();
            applyFilter();

            if (hasSaveSuccess) {
                clearDraft();
                setDraftBadgeState('saved');
                updateSubmitState();
            } else {
                setDraftBadgeState(isEditMode && !hasValidationErrors ? 'saved' : 'draft');
                updateSubmitState();
                restoreDraft();
                updateSubmitState();
                syncMassButtonText();
                updateStatusCounts();
            }
        });
    </script>
</x-app-layout>
