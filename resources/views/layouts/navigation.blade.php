<aside
    role="navigation"
    aria-label="Main navigation"
    class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col transform border-r border-white/20 bg-white/10 backdrop-blur-xl transition-transform duration-200 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    {{-- Logo / Brand --}}
    <div class="flex h-16 items-center border-b border-white/20 px-5">
        @php
            if (Auth::user()->role === 'admin') {
                $homeRoute = route('admin.dashboard');
            } elseif (Auth::user()->role === 'guru') {
                $homeRoute = route('guru.dashboard');
            } else {
                $homeRoute = route('dashboard');
            }
        @endphp
        <a href="{{ $homeRoute }}" class="flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/20">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <span class="text-sm font-semibold tracking-wide text-white">Pesantren App</span>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4 text-sm">
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('santri.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('santri.*') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
                Data Santri
            </a>

            <a href="{{ route('absensi.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('absensi.*') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Absensi
            </a>

            <a href="{{ route('laporan.absensi') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('laporan.absensi') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18"/>
                </svg>
                Laporan Absensi
            </a>
        @elseif (Auth::user()->role === 'guru')
            <a href="{{ route('guru.dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('guru.dashboard') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('absensi.index') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('absensi.*') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Absensi
            </a>

            <a href="{{ route('laporan.absensi') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('laporan.absensi') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18"/>
                </svg>
                Laporan Absensi
            </a>
        @else
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
        @endif
    </nav>

    {{-- User info at bottom --}}
    <div class="border-t border-white/20 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-white/10 px-3 py-2">
            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-white/20">
                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs capitalize text-white/60">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>
</aside>

<div
    x-cloak
    x-show="sidebarOpen"
    x-transition.opacity
    class="fixed inset-0 z-30 bg-black/50 backdrop-blur-sm lg:hidden"
    @click="sidebarOpen = false"
></div>
