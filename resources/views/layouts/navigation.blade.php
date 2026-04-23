<aside
    class="fixed inset-y-0 left-0 z-40 w-64 transform bg-slate-900 text-slate-100 transition-transform duration-200 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex h-16 items-center border-b border-slate-800 px-5">
        <a href="{{ route('dashboard') }}" class="text-sm font-semibold tracking-wide text-white">
            Admin Pesantren
        </a>
    </div>

    <nav class="space-y-1 px-3 py-4 text-sm">
        <a href="{{ route('dashboard') }}"
            class="block rounded-md px-3 py-2 transition {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            Dashboard
        </a>

        @if (Auth::user()->role === 'admin')
            <a href="{{ route('santri.index') }}"
                class="block rounded-md px-3 py-2 transition {{ request()->routeIs('santri.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Data Santri
            </a>
        @elseif (Auth::user()->role === 'guru')
            <a href="{{ route('absensi.index') }}"
                class="block rounded-md px-3 py-2 transition {{ request()->routeIs('absensi.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Absensi
            </a>

            <a href="{{ route('laporan.absensi') }}"
                class="block rounded-md px-3 py-2 transition {{ request()->routeIs('laporan.absensi') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Laporan Absensi
            </a>
        @endif
    </nav>
</aside>

<div
    x-cloak
    x-show="sidebarOpen"
    x-transition.opacity
    class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
    @click="sidebarOpen = false"
></div>
