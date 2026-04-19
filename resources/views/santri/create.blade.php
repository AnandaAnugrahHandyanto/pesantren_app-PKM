<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Santri</h1>

        <form action="{{ route('santri.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label>NIS</label>
                <input type="text" name="nis" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Nama</label>
                <input type="text" name="nama" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Kelas</label>
                <input type="text" name="kelas" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Kamar</label>
                <input type="text" name="kamar" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="border rounded w-full p-2">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>

