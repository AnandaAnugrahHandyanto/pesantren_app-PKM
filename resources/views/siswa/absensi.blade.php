<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            <svg class="mr-2 inline-block h-5 w-5 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
            </svg>
            Riwayat Absensi</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-x-auto rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-xl">
                @if($absensis->isEmpty())
                    <p class="py-8 text-center text-sm text-white/40">Belum ada data absensi.</p>
                @else
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-xs uppercase tracking-wider text-white/50">
                                <th class="px-3 py-2 font-medium">Tanggal</th>
                                <th class="px-3 py-2 font-medium">Mata Pelajaran</th>
                                <th class="px-3 py-2 font-medium">Status</th>
                                <th class="px-3 py-2 font-medium">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensis as $a)
                            <tr class="border-b border-white/5 transition hover:bg-white/5">
                                <td class="px-3 py-2.5 text-white/80">{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('l, d M Y') }}</td>
                                <td class="px-3 py-2.5 text-white/80">{{ $a->mataPelajaran->nama ?? '-' }}</td>
                                <td class="px-3 py-2.5">
                                    <span class="status-capsule status-{{ $a->status }}">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 text-white/60">{{ $a->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $absensis->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
