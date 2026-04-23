<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">Tambah Santri</h1>
    </x-slot>

    <div class="mx-auto max-w-xl">
        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg backdrop-blur-md">
            <form action="{{ route('santri.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-white/80">NIS</label>
                    <input type="text" name="nis"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-white/80">Nama</label>
                    <input type="text" name="nama"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-white/80">Kelas</label>
                    <input type="text" name="kelas"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-white/80">Kamar</label>
                    <input type="text" name="kamar"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/40 backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-white/80">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full rounded-xl border border-white/30 bg-white/10 px-3 py-2 text-sm text-white backdrop-blur-sm focus:border-white/50 focus:outline-none focus:ring-2 focus:ring-white/20">
                        <option value="L" class="bg-indigo-950 text-white">Laki-laki</option>
                        <option value="P" class="bg-indigo-950 text-white">Perempuan</option>
                    </select>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="rounded-xl bg-indigo-500/80 px-5 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-indigo-400/80">
                        Simpan
                    </button>
                    <a href="{{ route('santri.index') }}"
                        class="rounded-xl border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white/80 backdrop-blur-sm transition hover:bg-white/20">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

