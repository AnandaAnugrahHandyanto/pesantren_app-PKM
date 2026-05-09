<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Absensi Massal Santri</h1>
    </x-slot>

    @php
        $statusLabels = [
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alfa' => 'Alfa',
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
                    <label for="search_santri" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-white/75">Cari Santri</label>
                    <input id="search_santri" type="text" placeholder="Ketik nama santri..."
                        class="w-full rounded-lg border border-white/25 bg-white/10 px-3 py-2 text-sm text-white placeholder:text-white/45 focus:border-cyan-300/70 focus:outline-none focus:ring-2 focus:ring-cyan-300/30">
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-2">
                <button type="submit"
                    class="rounded-lg border border-white/30 bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">
                    Tampilkan Data
                </button>
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
                    0 / {{ $santris->count() }} santri tampil
                </span>
            </div>
        </form>

        <form method="POST" action="{{ route('absensi.mass-store') }}" id="mass-absensi-form" class="glass-panel rounded-2xl">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="kategori" value="{{ $kategori }}">

            <div class="flex items-center justify-between border-b border-white/15 px-4 py-3 sm:px-5">
                <div class="flex flex-wrap items-center gap-2 text-sm text-white/75">
                    <span>Isi status lalu klik <span class="font-semibold text-white">Simpan Absensi</span></span>
                    <span id="draft-state-badge"
                        class="rounded-full border px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-wide">
                    </span>
                    <span id="filled-counter" class="text-xs font-semibold text-white/70"></span>
                </div>
                <button type="submit"
                    id="btn-simpan-absensi"
                    class="rounded-lg bg-gradient-to-r from-cyan-500/90 to-blue-600/90 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-cyan-500/20 transition hover:from-cyan-400 hover:to-blue-500">
                    Simpan Absensi
                </button>
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
                        @forelse ($santris as $index => $santri)
                            <tr class="attendance-row transition duration-150 hover:bg-white/10"
                                data-santri-row
                                data-name="{{ strtolower($santri->nama_lengkap) }}"
                                data-kelas="{{ strtolower($santri->kelas ?? '-') }}"
                                data-row-id="{{ $santri->id }}">
                                <td class="px-3 py-2.5 text-sm text-white/70">{{ $index + 1 }}</td>
                                <td class="px-3 py-2.5 text-sm font-medium text-white">
                                    <span>{{ $santri->nama_lengkap }}</span>
                                </td>
                                <td class="px-3 py-2.5 text-sm text-white/80">{{ $santri->kelas ?? '-' }}</td>
                                <td class="px-3 py-2.5 text-sm text-white/80">{{ $santri->jenis_kelamin ?? '-' }}</td>
                                <td class="px-3 py-2.5">
                                    <input type="hidden" name="absensi[{{ $santri->id }}]" value="{{ old("absensi.{$santri->id}", '') }}" data-status-input>
                                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                                        @foreach ($statusOptions as $statusOption)
                                            <button type="button"
                                                data-status-btn="{{ $statusOption }}"
                                                class="status-badge rounded-lg border border-white/20 px-2 py-1.5 text-xs font-semibold text-white/90 transition hover:-translate-y-[1px]">
                                                {{ $statusLabels[$statusOption] }}
                                            </button>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-white/55">
                                    Data santri belum tersedia.
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rows = Array.from(document.querySelectorAll('[data-santri-row]'));
            const kelasFilter = document.getElementById('kelas_filter');
            const searchInput = document.getElementById('search_santri');
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
            const storageKey = `absensi-draft:${tanggal}:${kategori}`;
            const hasSaveSuccess = @js((bool) session('success'));
            const defaultButtonClass = 'status-badge rounded-lg border border-white/20 px-2 py-1.5 text-xs font-semibold text-white/90 transition duration-150 hover:-translate-y-[1px]';

            const rowStatusClasses = {
                hadir: ['bg-emerald-500/20', 'hover:bg-emerald-500/25'],
                izin: ['bg-yellow-500/20', 'hover:bg-yellow-500/25'],
                sakit: ['bg-blue-500/20', 'hover:bg-blue-500/25'],
                alfa: ['bg-red-500/20', 'hover:bg-red-500/25'],
            };

            const badgeClasses = {
                hadir: 'border-emerald-300/60 bg-emerald-500/30 text-emerald-100',
                izin: 'border-yellow-300/60 bg-yellow-500/30 text-yellow-100',
                sakit: 'border-blue-300/60 bg-blue-500/30 text-blue-100',
                alfa: 'border-red-300/60 bg-red-500/30 text-red-100',
            };

            const normalize = (value) => (value || '').toLowerCase().trim();
            const isAllHadir = () => rows.every((row) => row.querySelector('[data-status-input]').value === 'hadir');
            const getFilledCount = () => rows.filter((row) => row.querySelector('[data-status-input]').value).length;

            const clearDraft = () => localStorage.removeItem(storageKey);

            const setDraftBadgeState = (state) => {
                draftStateBadge.className = 'rounded-full border px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-wide';
                if (state === 'saved') {
                    draftStateBadge.classList.add('border-emerald-300/40', 'bg-emerald-500/20', 'text-emerald-100');
                    draftStateBadge.textContent = 'Tersimpan';
                    return;
                }

                draftStateBadge.classList.add('border-orange-300/40', 'bg-orange-500/20', 'text-orange-100');
                draftStateBadge.textContent = 'Belum disimpan';
            };

            const updateSubmitState = () => {
                const filledCount = getFilledCount();
                const allFilled = totalRows > 0 && filledCount === totalRows;
                submitBtn.disabled = !allFilled;
                submitBtn.classList.toggle('opacity-50', !allFilled);
                submitBtn.classList.toggle('cursor-not-allowed', !allFilled);
                filledCounter.textContent = `${filledCount} / ${totalRows} santri sudah diabsen`;
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

            const updateRowVisual = (row, status) => {
                row.classList.remove(
                    'bg-emerald-500/20', 'hover:bg-emerald-500/25',
                    'bg-yellow-500/20', 'hover:bg-yellow-500/25',
                    'bg-blue-500/20', 'hover:bg-blue-500/25',
                    'bg-red-500/20', 'hover:bg-red-500/25'
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
                markDraft: true
            }) => {
                const input = row.querySelector('[data-status-input]');
                input.value = status;
                updateRowVisual(row, status);

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

                visibleCounter.textContent = `${visible} / ${rows.length} santri tampil`;
            };

            const resetAllStatuses = (markDraft = true) => {
                rows.forEach((row) => {
                    setStatus(row, '', { persistDraft: false, markDraft: false });
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
                        setStatus(row, status, { persistDraft: false, markDraft: false });
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
                        setStatus(row, status);
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
                    setStatus(row, 'hadir', { persistDraft: false, markDraft: false });
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
                        setStatus(row, 'alfa', { persistDraft: false, markDraft: false });
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
                setDraftBadgeState('draft');
                updateSubmitState();
                restoreDraft();
                updateSubmitState();
                syncMassButtonText();
            }
        });
    </script>
</x-app-layout>
