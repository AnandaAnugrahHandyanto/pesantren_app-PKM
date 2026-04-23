<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Input Absensi</h1>

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('absensi.store') }}" method="POST" class="bg-white rounded shadow p-6">
            @csrf

            <div class="mb-4">
                <label for="santri_id" class="block text-sm font-medium text-gray-700 mb-1">Santri</label>
                <select id="santri_id" name="santri_id" class="border rounded w-full p-2" required>
                    <option value="" disabled selected>Pilih santri</option>
                    @foreach ($santris as $santri)
                        <option value="{{ $santri->id }}" {{ old('santri_id') == $santri->id ? 'selected' : '' }}>
                            {{ $santri->nis }} – {{ $santri->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal"
                    value="{{ old('tanggal', today()->toDateString()) }}"
                    class="border rounded w-full p-2" required>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="border rounded w-full p-2" required>
                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih status</option>
                    <option value="hadir" {{ old('status') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin"  {{ old('status') === 'izin'  ? 'selected' : '' }}>Izin</option>
                    <option value="alfa"  {{ old('status') === 'alfa'  ? 'selected' : '' }}>Alfa</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Simpan
                </button>
                <a href="{{ route('absensi.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
