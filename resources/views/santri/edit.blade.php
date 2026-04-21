<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Santri</h1>

        <form action="{{ route('santri.update', $santri) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nis">NIS</label>
                <input type="text" id="nis" name="nis" value="{{ old('nis', $santri->nis) }}" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $santri->nama) }}" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label for="kelas">Kelas</label>
                <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $santri->kelas) }}" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label for="kamar">Kamar</label>
                <input type="text" id="kamar" name="kamar" value="{{ old('kamar', $santri->kamar) }}" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="border rounded w-full p-2">
                    <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">
                Update
            </button>
        </form>
    </div>
</x-app-layout>
