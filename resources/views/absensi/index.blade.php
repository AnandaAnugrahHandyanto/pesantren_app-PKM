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
            <div class="rounded-xl border border-emerald-400/30 bg-emerald-500/20 px-4 py-3 text-sm font-semibold text-emerald-100 backdrop-blur-sm">
                Semua absensi untuk kategori ini sudah lengkap.
            </div>
        @endif

        <form method="GET" action="{{ route('absensi.index') }}" class="glass-panel rounded-2xl p-4 sm:p-5">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label for="tanggal_filter" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-white/75">Tanggal</label>
                    <input id="tanggal_filter" type="date" name="tanggal" value="{{ $tanggal }}"
                        class="w-full rounded-lg border border-white/25 bg-white/10 px-3 py-2 text-sm text-white focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                </div>
                <div>
                    <label for="kategori_filter" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-white/75">Kategori</label>
                    <select id="kategori_filter" name="kategori"
                        class="w-full rounded-lg border border-white/25 bg-white/10 px-3 py-2 text-sm text-white focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                        @foreach ($kategoriOptions as $kategoriItem)
                            <option value="{{ $kategoriItem }}" @selected($kategori === $kategoriItem) class="bg-indigo-950 text-white">
                                {{ ucfirst($kategoriItem) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="kelas_filter" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-white/75">Filter Kelas</label>
                    <select id="kelas_filter"
                        class="w-full rounded-lg border border-white/25 bg-white/10 px-3 py-2 text-sm text-white focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                        <option value="" class="bg-indigo-950 text-white">Semua Kelas</option>
                        @foreach ($kelasOptions as $kelas)
                            <option value="{{ $kelas }}" class="bg-indigo-950 text-white">{{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="search_siswa" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-white/75">Cari Siswa</label>
                    <input id="search_siswa" type="text" placeholder="Ketik nama siswa..."
                        class="w-full rounded-lg border border-white/25 bg-white/10 px-3 py-2 text-sm text-white placeholder:text-white/45 focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-2">
                <button type="submit"
                    class="rounded-lg border border-white/30 bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">
                    Tampilkan Data
                </button>
                @if ($hasExistingAbsensi)
                    <span class="rounded-full border border-orange-300/40 bg-orange-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-orange-100">
                        Absensi Sudah Ada ({{ $existingCount }} data)
                    </span>
                @endif
                <button type="button" id="btn-hadir-semua"
                    class="rounded-lg border border-emerald-300/50 bg-emerald-500/20 px-4 py-2 text-sm font-semibold text-emerald-100 transition hover:bg-emerald-500/30">
                    Hadir Semua
                </button>
                <button type="button" id="btn-isi-alfa"
                    class="rounded-lg border border-rose-300/40 bg-rose-500/20 px-4 py-2 text-sm font-semibold text-rose-100 transition hover:bg-rose-500/30">
                    Isi Belum Absen Menjadi Alfa
                </button>
                <button type="button" id="btn-reset-absensi"
                    class="rounded-lg border border-white/30 bg-white/10 px-4 py-2 text-sm font-semibold text-white/90 transition hover:bg-white/20">
                    Reset Absensi
                </button>
                <span id="visible-counter" class="ms-auto text-xs font-medium text-white/70">
                    0 / {{ $siswas->count() }} siswa tampil
                </span>
            </div>
        </form>

        <form method="POST" action="{{ route('absensi.mass-store') }}" id="mass-absensi-form" class="glass-panel rounded-2xl">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="kategori" value="{{ $kategori }}">
            <input type="hidden" name="form_mode" value="{{ $absensiMode }}">

            <div class="flex items-center justify-between border-b border-white/15 px-4 py-3 sm:px-5">
                <div class="flex flex-wrap items-center gap-2 text-sm text-white/75">
                    <span>{{ $absensiMode === 'edit' ? 'Edit status lalu klik' : 'Isi status lalu klik' }} <span
                            class="font-semibold text-white">{{ $absensiMode === 'edit' ? 'Update Absensi' : 'Simpan Absensi' }}</span></span>
                    <span id="draft-state-badge"
                        class="rounded-full border px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-wide">
                    </span>
                    <span id="filled-counter" class="text-xs font-semibold text-white/70"></span>
                </div>
                <button type="submit"
                    id="btn-simpan-absensi"
                    class="rounded-lg bg-gradient-to-r from-cyan-500/90 to-blue-600/90 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-cyan-500/20 transition hover:from-cyan-400 hover:to-blue-500">
                    {{ $absensiMode === 'edit' ? 'Update Absensi' : 'Simpan Absensi' }}
                </button>
            </div>

            <div class="grid gap-2 border-b border-white/10 px-4 py-3 text-xs text-white/75 sm:grid-cols-2 lg:grid-cols-5 sm:px-5">
                <div><span class="text-white/55">Kategori aktif:</span> <span class="font-semibold text-white">{{ ucfirst($kategori) }}</span></div>
                <div><span class="text-white/55">Tanggal aktif:</span> <span class="font-semibold text-white">{{ $tanggal }}</span></div>
                <div><span class="text-white/55">Jumlah siswa:</span> <span class="font-semibold text-white">{{ $totalSiswa }}</span></div>
                <div><span class="text-white/55">Sudah diabsen:</span> <span class="font-semibold text-white">{{ $existingCount }}</span></div>
                <div><span class="text-white/55">Terakhir diupdate:</span> <span class="font-semibold text-white">{{ $lastUpdatedAt ? \Illuminate\Support\Carbon::parse($lastUpdatedAt)->format('d-m-Y H:i') : '-' }}</span></div>
            </div>

            <div class="table-scroll-wrapper">
                <table class="min-w-full table-fixed">
                    <thead class="table-header-sticky bg-white/10 backdrop-blur-sm">
                        <tr class="border-b border-white/10">
                            <th class="w-16 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/75">No</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/75">Nama Lengkap</th>
                            <th class="w-32 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/75">Kelas</th>
                            <th class="w-36 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/75">Jenis Kelamin</th>
                            <th class="w-[22rem] px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/75">Status Absensi</th>
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
                                data-kelas="{{ strtolower($siswa->kelas ?? '-') }}"
                                data-row-id="{{ $siswa->id }}"
                                data-existing-status="{{ $existingStatus }}"
                                data-initial-status="{{ $initialStatus }}">
                                <td class="px-3 py-2.5 text-sm text-white/70">{{ $index + 1 }}</td>
                                <td class="px-3 py-2.5 text-sm font-medium text-white">
                                    <span>{{ $siswa->nama_lengkap }}</span>
                                </td>
                                <td class="px-3 py-2.5 text-sm text-white/80">{{ $siswa->kelas ?? '-' }}</td>
                                <td class="px-3 py-2.5 text-sm text-white/80">{{ $siswa->jenis_kelamin ?? '-' }}</td>
                                <td class="px-3 py-2.5">
                                    <input type="hidden" name="absensi[{{ $siswa->id }}]" value="{{ $initialStatus }}" data-status-input>
                                    <div class="grid grid-cols-2 gap-1.5 sm:grid-cols-4">
                                        @foreach ($statusOptions as $statusOption)
                                            <button type="button"
                                                data-status-btn="{{ $statusOption }}"
                                                title="{{ $statusTooltips[$statusOption] }}"
                                                class="status-btn">
                                                <x-status-icon :status="$statusOption" class="h-3.5 w-3.5 shrink-0" />
                                                {{ $statusLabels[$statusOption] }}
                                            </button>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-white/55">
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
                    text: `Absensi kategori ${warning.kategori} pada tanggal ${warning.tanggal} sudah pernah dilakukan. Silakan gunakan mode edit untuk memperbarui data.`,
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
            const kategori = form.querySelector('input[name="kategori"]').value;
            const formMode = form.querySelector('input[name="form_mode"]').value;
            const isEditMode = formMode === 'edit';
            const storageKey = `absensi-draft:${tanggal}:${kategori}`;
            const hasSaveSuccess = @js((bool) session('success'));
            const hasValidationErrors = @js($errors->any());
            const defaultButtonClass = 'status-btn';
            const changedFlashClass = ['ring-1', 'ring-orange-300/70', 'bg-orange-500/10'];

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

            const setDraftBadgeState = (state) => {
                draftStateBadge.className = 'rounded-full border px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-wide';
                if (state === 'saved') {
                    draftStateBadge.classList.add('border-emerald-300/40', 'bg-emerald-500/20', 'text-emerald-100');
                    draftStateBadge.textContent = 'Data tersimpan di database';
                    return;
                }

                draftStateBadge.classList.add('border-orange-300/40', 'bg-orange-500/20', 'text-orange-100');
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
                    ? 'rounded-lg border border-slate-300/50 bg-slate-500/20 px-4 py-2 text-sm font-semibold text-slate-100 transition hover:bg-slate-500/30'
                    : 'rounded-lg border border-emerald-300/50 bg-emerald-500/20 px-4 py-2 text-sm font-semibold text-emerald-100 transition hover:bg-emerald-500/30';
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
                        button.className = `${button.className} ${badgeClasses[status]}`;
                    }
                });
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

            isiAlfaBtn?.addEventListener('click', () => {
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

            resetAbsensiBtn?.addEventListener('click', () => {
                resetAllStatuses(true);
            });

            kelasFilter?.addEventListener('change', applyFilter);
            searchInput?.addEventListener('input', applyFilter);
            syncMassButtonText();
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
            }
        });
    </script>
</x-app-layout>
