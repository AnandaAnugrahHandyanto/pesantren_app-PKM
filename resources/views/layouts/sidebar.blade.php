<aside
    x-cloak
    class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-white/20 bg-gradient-to-br from-blue-950 via-indigo-950 to-cyan-950 backdrop-blur-xl transition-transform duration-200 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <div class="flex h-16 items-center border-b border-white/20 px-5">
        <span class="text-sm font-semibold tracking-wide text-white">Sekolah App</span>
    </div>
    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition text-white/70 hover:bg-white/10 hover:text-white">Dashboard</a>
        <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition text-white/70 hover:bg-white/10 hover:text-white">Data Siswa</a>
        <a href="{{ route('jadwal.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition text-white/70 hover:bg-white/10 hover:text-white">Jadwal</a>
        <!-- Add others -->
    </nav>
</aside>
