<aside
    x-cloak
    role="navigation"
    aria-label="Main navigation"
    class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r bg-white/90 backdrop-blur-xl transition-transform duration-200 ease-in-out lg:translate-x-0 border-slate-200/80 dark:border-white/20 dark:bg-slate-900/80"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    {{-- Logo / Brand --}}
    <div class="flex h-16 items-center border-b px-5 border-slate-200/80 dark:border-white/20">
        @php
            if (Auth::user()->role === 'admin') {
                $homeRoute = route('admin.dashboard');
            } elseif (Auth::user()->role === 'guru') {
                $homeRoute = route('guru.dashboard');
            } elseif (Auth::user()->role === 'siswa') {
                $homeRoute = route('siswa.dashboard');
            } else {
                $homeRoute = route('dashboard');
            }
        @endphp
        <a href="{{ $homeRoute }}" class="flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-200/50 dark:bg-white/20">
                <svg class="h-5 w-5 text-slate-900 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <span class="text-sm font-semibold tracking-wide text-slate-900 dark:text-white">Sekolah App</span>
        </a>

        <button
            type="button"
            class="ml-auto rounded-lg p-1.5 text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white lg:hidden"
            @click="sidebarOpen = false"
            aria-label="Close sidebar"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-4 text-sm">
        @if (Auth::user()->role === 'admin')
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </div>

            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-white/50">Data</p>
                <a href="{{ route('siswa.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                    Siswa
                </a>
                <a href="{{ route('guru.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('guru.*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Guru
                </a>
                <a href="{{ route('mata-pelajaran.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('mata-pelajaran.*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11a3 3 0 10-6 0"/>
                    </svg>
                    Mata Pelajaran
                </a>
                <a href="{{ route('jadwal.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('jadwal.*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Jadwal
                </a>
            </div>

            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-white/50">Absensi</p>
                <a href="{{ route('absensi.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('absensi.*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Absensi
                </a>
                <a href="{{ route('laporan.absensi') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('laporan.absensi*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18"/>
                    </svg>
                    Rekap Absensi
                </a>
            </div>

            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-white/50">Keuangan</p>
                <a href="{{ route('keuangan.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('keuangan.*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 2c4.41 0 8 3.59 8 8s-3.59 8-8 8-8-3.59-8-8 3.59-8 8-8zm-1 13h2v-6h-2v6zm0-8h2V5h-2v4z"/>
                    </svg>
                    Keuangan
                </a>
                <a href="{{ route('spp.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('spp.*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h2v-2h-2v2zm0-4h2V7h-2v6z"/>
                    </svg>
                    SPP
                </a>
            </div>
        @elseif (Auth::user()->role === 'guru')
            <div class="space-y-1">
                <a href="{{ route('guru.dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('guru.dashboard') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </div>
            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-white/50">Akademik</p>
                <a href="{{ route('absensi.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('absensi.*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Absensi
                </a>
                <a href="{{ route('laporan.absensi') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('laporan.absensi*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18"/>
                    </svg>
                    Rekap Absensi
                </a>
                <a href="{{ route('guru.jadwal') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('guru.jadwal') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Jadwal
                </a>
            </div>
        @elseif (Auth::user()->role === 'siswa')
            <div class="space-y-1">
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.dashboard') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </div>
            <div class="space-y-1">
                <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-white/50">Akademik</p>
                <a href="{{ route('siswa.absensi') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.absensi*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Riwayat Absensi
                </a>
                <a href="{{ route('siswa.spp.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.spp*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h2v-2h-2v2zm0-4h2V7h-2v6z"/>
                    </svg>
                    Tagihan SPP
                </a>
                <a href="{{ route('siswa.jadwal') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.jadwal*') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Jadwal
                </a>
            </div>
        @else
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('dashboard') ? 'bg-cyan-50 text-cyan-700 dark:bg-white/20 dark:text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-slate-900 dark:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
        @endif
    </nav>

    {{-- User info at bottom --}}
    <div class="border-t p-4 border-slate-200/80 dark:border-white/20" x-data="{ isDark: document.documentElement.classList.contains('dark') }">
        <div class="flex items-center justify-between gap-3 rounded-xl px-3 py-2 bg-slate-100/80 dark:bg-white/10">
            <div class="flex items-center gap-3 min-w-0">
                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-slate-200/50 dark:bg-white/20">
                    <svg class="h-4 w-4 text-slate-600 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-slate-800 dark:text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs capitalize text-slate-500 dark:text-white/60">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <button
                type="button"
                class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-200 hover:text-slate-900 dark:text-white/70 dark:hover:bg-white/20 dark:hover:text-white"
                @click="
                    isDark = !isDark;
                    document.documentElement.classList.toggle('dark', isDark);
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                "
                :aria-label="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
            >
                {{-- Moon Icon --}}
                <svg x-show="!isDark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                {{-- Sun Icon --}}
                <svg x-show="isDark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>
        </div>
    </div>
</aside>

<div
    x-cloak
    x-show="sidebarOpen"
    x-transition.opacity
    class="fixed inset-0 z-30 bg-black/50 lg:hidden"
    @click="sidebarOpen = false"
></div>
