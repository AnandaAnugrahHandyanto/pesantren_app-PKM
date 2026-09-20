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
    <nav class="flex-1 space-y-8 overflow-y-auto px-3 py-4 text-sm">
        @if (Auth::user()->role === 'admin')
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">PLATFORM</p>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="home" class="h-4 w-4"></i>
                    {{ config('navigation.admin.dashboard.index.sidebar') }}
                </a>
            </div>

            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">DATA</p>
                <a href="{{ route('siswa.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="users" class="h-4 w-4"></i>
                    {{ config('navigation.admin.siswa.index.sidebar') }}
                </a>
                <a href="{{ route('guru.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('guru.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="graduation-cap" class="h-4 w-4"></i>
                    {{ config('navigation.admin.guru.index.sidebar') }}
                </a>
                <a href="{{ route('mata-pelajaran.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('mata-pelajaran.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="book-open" class="h-4 w-4"></i>
                    {{ config('navigation.admin.mata-pelajaran.index.sidebar') }}
                </a>
            </div>

            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">AKADEMIK</p>
                <a href="{{ route('jadwal.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('jadwal.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="calendar-days" class="h-4 w-4"></i>
                    {{ config('navigation.admin.jadwal.index.sidebar') }}
                </a>
            </div>

            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">ABSENSI</p>
                <a href="{{ route('absensi.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('absensi.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="clipboard-check" class="h-4 w-4"></i>
                    {{ config('navigation.admin.absensi.index.sidebar') }}
                </a>
                <a href="{{ route('laporan.absensi') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('laporan.absensi*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
                    {{ config('navigation.admin.laporan.absensi.sidebar') }}
                </a>
            </div>

            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">KEUANGAN</p>
                <a href="{{ route('keuangan.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('keuangan.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="wallet" class="h-4 w-4"></i>
                    {{ config('navigation.admin.keuangan.index.sidebar') }}
                </a>
                <a href="{{ route('spp.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('spp.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="badge-dollar-sign" class="h-4 w-4"></i>
                    {{ config('navigation.admin.spp.index.sidebar') }}
                </a>
            </div>
        @elseif (Auth::user()->role === 'guru')
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">PLATFORM</p>
                <a href="{{ route('guru.dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('guru.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="home" class="h-4 w-4"></i>
                    {{ config('navigation.guru.dashboard.index.sidebar') }}
                </a>
            </div>
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">AKADEMIK</p>
                <a href="{{ route('guru.jadwal') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('guru.jadwal') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="calendar-days" class="h-4 w-4"></i>
                    {{ config('navigation.guru.jadwal.index.sidebar') }}
                </a>
            </div>
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">ABSENSI</p>
                <a href="{{ route('absensi.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('absensi.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="clipboard-check" class="h-4 w-4"></i>
                    {{ config('navigation.guru.absensi.index.sidebar') }}
                </a>
                <a href="{{ route('laporan.absensi') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('laporan.absensi*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
                    {{ config('navigation.guru.laporan.absensi.sidebar') }}
                </a>
            </div>
        @elseif (Auth::user()->role === 'siswa')
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">PLATFORM</p>
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="home" class="h-4 w-4"></i>
                    {{ config('navigation.siswa.dashboard.index.sidebar') }}
                </a>
            </div>
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">AKADEMIK</p>
                <a href="{{ route('siswa.absensi') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.absensi*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="clipboard-check" class="h-4 w-4"></i>
                    {{ config('navigation.siswa.absensi.index.sidebar') }}
                </a>
                <a href="{{ route('siswa.jadwal') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.jadwal*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="calendar-days" class="h-4 w-4"></i>
                    {{ config('navigation.siswa.jadwal.index.sidebar') }}
                </a>
            </div>
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">KEUANGAN</p>
                <a href="{{ route('siswa.spp.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('siswa.spp*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <i data-lucide="badge-dollar-sign" class="h-4 w-4"></i>
                    {{ config('navigation.siswa.spp.index.sidebar') }}
                </a>
            </div>
        @else
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                <i data-lucide="home" class="h-4 w-4"></i>
                Dashboard
            </a>
        @endif
    </nav>

    {{-- User info at bottom --}}
    <div class="border-t p-4 border-slate-200/80 dark:border-white/20">
        <div x-data="{ open: false }" class="relative">
            <div @click="open = !open" class="flex items-center justify-between gap-3 rounded-xl px-3 py-2 bg-slate-100/80 dark:bg-white/10 cursor-pointer hover:bg-slate-200/80 dark:hover:bg-white/20 transition group">
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-slate-200/50 dark:bg-white/20">
                        <i data-lucide="user" class="h-4 w-4 text-slate-600 dark:text-white"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-slate-800 dark:text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs capitalize text-slate-500 dark:text-white/60">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
            </div>
            
            {{-- Dropdown (Open Upward) --}}
            <div x-show="open" 
                 x-cloak
                 @click.outside="open = false" 
                 @keydown.escape.window="open = false"
                 class="absolute bottom-full mb-2 right-0 w-48 rounded-xl border border-slate-200 bg-white p-1 shadow-xl dark:border-slate-700 dark:bg-slate-800 z-50 origin-bottom"
                 x-transition:enter="transition ease-out duration-250"
                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700/50">
                    <i data-lucide="user" class="h-4 w-4"></i>
                    Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                        Logout
                    </button>
                </form>
            </div>
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
