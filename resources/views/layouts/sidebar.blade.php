<aside
    x-cloak
    class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-white/20 bg-gradient-to-br from-blue-950 via-indigo-950 to-cyan-950 backdrop-blur-xl transition-transform duration-200 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex h-16 items-center border-b border-white/20 px-5 gap-3">
        <svg class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
        </svg>
        <span class="text-sm font-semibold tracking-wide text-white">Sekolah App</span>
    </div>
    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4 text-sm">
        @php
            $links = [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/>'],
                ['route' => 'siswa.index', 'label' => 'Data Siswa', 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
                ['route' => 'guru.index', 'label' => 'Data Guru', 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M16 3.13V21"/>'],
                ['route' => 'absensi.index', 'label' => 'Absensi', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/>'],
                ['route' => 'laporan.absensi', 'label' => 'Rekap Absensi', 'icon' => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>'],
                ['route' => 'mata-pelajaran.index', 'label' => 'Mata Pelajaran', 'icon' => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>'],
                ['route' => 'keuangan.index', 'label' => 'Keuangan', 'icon' => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>'],
                ['route' => 'spp.index', 'label' => 'SPP', 'icon' => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12.01" y2="16"/><path d="M12 12V8"/>'],
                ['route' => 'jadwal.index', 'label' => 'Jadwal', 'icon' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
            ];
        @endphp

        @foreach($links as $link)
            <a href="{{ route($link['route']) }}" 
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs($link['route'].'*') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    {!! $link['icon'] !!}
                </svg>
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
</aside>