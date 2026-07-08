<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">✏️ Edit Jadwal</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl">
                <form method="POST" action="{{ route('jadwal.update', $jadwal) }}">
                    @csrf @method('PUT')

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-white/70">Hari</label>
                                <select name="hari" required class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                                    @foreach(['senin','selasa','rabu','kamis','jumat','sabtu'] as $h)
                                        <option value="{{ $h }}" {{ $jadwal->hari == $h ? 'selected' : '' }}>{{ ucfirst($h) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-white/70">Kelas</label>
                                <select name="kelas" required class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                                    @foreach($kelasList as $k)
                                        <option value="{{ $k }}" {{ $jadwal->kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-white/70">Jam Mulai</label>
                                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) }}" required
                                       class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-white/70">Jam Selesai</label>
                                <input type="time" name="jam_selesai" value="{{ old('jam_selesai', substr($jadwal->jam_selesai, 0, 5)) }}" required
                                       class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-white/70">Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" required class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}" {{ $jadwal->mata_pelajaran_id == $m->id ? 'selected' : '' }}>{{ $m->nama }} ({{ $m->kelas }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-white/70">Guru Pengajar</label>
                            <select name="guru_id" class="mt-1 block w-full rounded-xl border-white/20 bg-white/10 px-4 py-2.5 text-white">
                                <option value="">Pilih Guru</option>
                                @foreach($gurus as $g)
                                    <option value="{{ $g->id }}" {{ $jadwal->guru_id == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="rounded-xl bg-cyan-500/20 px-6 py-2.5 font-medium text-cyan-200 ring-1 ring-cyan-400/30 hover:bg-cyan-500/30">Update</button>
                        <a href="{{ route('jadwal.index', ['kelas' => $jadwal->kelas]) }}" class="rounded-xl bg-white/10 px-6 py-2.5 text-white hover:bg-white/20">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
