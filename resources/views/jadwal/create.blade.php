<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900 dark:text-white">Tambah Jadwal</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 p-6 backdrop-blur-xl">
                <form method="POST" action="{{ route('jadwal.store') }}" onsubmit="return validateTimes(this)">
                    @csrf
                    <input type="hidden" name="kelas" value="{{ request('kelas', old('kelas')) }}">

                    <div class="space-y-4">
                        @if ($errors->any())
                            <div class="rounded-xl bg-red-500/20 p-4 border border-red-500/30 text-red-200 text-sm">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Hari</label>
                                <select name="hari" required class="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2.5 text-slate-900 dark:text-white">
                                    @foreach(['senin','selasa','rabu','kamis','jumat','sabtu'] as $h)
                                        <option value="{{ $h }}">{{ ucfirst($h) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Kelas</label>
                                <select name="kelas" required class="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2.5 text-slate-900 dark:text-white">
                                    @foreach($kelasList as $k)
                                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Rombel</label>
                            <select name="rombel" required class="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2.5 text-slate-900 dark:text-white">
                                <option value="" disabled selected>Pilih Rombel</option>
                                @foreach(\App\Models\Siswa::rombelOptions() as $r)
                                    <option value="{{ $r }}">{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Jam Mulai</label>
                                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '07:00') }}" required
                                       class="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2.5 text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Jam Selesai</label>
                                <input type="time" name="jam_selesai" value="{{ old('jam_selesai', '07:45') }}" required
                                       class="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2.5 text-slate-900 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" id="mata_pelajaran_id" required class="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2.5 text-slate-900 dark:text-white">
                                <option value="">Pilih Mapel</option>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}" data-guru-id="{{ $m->guru_id }}">{{ $m->nama }} ({{ $m->kelas }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-900 dark:text-slate-600 dark:text-white/70">Guru Pengajar</label>
                            <select name="guru_id" id="guru_id" class="mt-1 block w-full rounded-xl border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 px-4 py-2.5 text-slate-900 dark:text-white">
                                <option value="">Pilih Guru</option>
                                @foreach($gurus as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="rounded-xl bg-cyan-500/20 px-6 py-2.5 font-medium text-cyan-900 dark:text-cyan-200 ring-1 ring-cyan-400/30 hover:bg-cyan-500/30">Simpan</button>
                        <a href="{{ route('jadwal.index', ['kelas' => request('kelas')]) }}" class="rounded-xl bg-slate-50 dark:bg-white/10 px-6 py-2.5 text-slate-900 dark:text-white hover:bg-white/20">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('mata_pelajaran_id').addEventListener('change', function() {
            var guruSelect = document.getElementById('guru_id');
            var selectedOption = this.options[this.selectedIndex];
            var guruId = selectedOption.getAttribute('data-guru-id');

            if (guruId) {
                guruSelect.value = guruId;
            } else {
                guruSelect.value = '';
            }
        });

        function validateTimes(form) {
            const start = form.querySelector('input[name="jam_mulai"]').value;
            const end = form.querySelector('input[name="jam_selesai"]').value;
            if (start >= end) {
                Swal.fire({
                    icon: 'error',
                    title: 'Waktu Tidak Valid',
                    text: 'Jam mulai tidak boleh sama dengan atau setelah jam selesai. Periksa kembali jadwal Anda.',
                    confirmButtonColor: '#06b6d4',
                    background: '#1e293b',
                    color: '#fff'
                });
                return false;
            }
            return true;
        }
    </script>
</x-app-layout>