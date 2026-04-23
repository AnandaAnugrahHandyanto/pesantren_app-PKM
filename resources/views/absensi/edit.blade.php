<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Absensi</h1>

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('absensi.update', $absensi) }}" method="POST" class="bg-white rounded shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="santri_id" class="block text-sm font-medium text-gray-700 mb-1">Santri</label>
                <select id="santri_id" name="santri_id" class="border rounded w-full p-2" required>
                    <option value="" disabled>Pilih santri</option>
                    @foreach ($santris as $santri)
                        <option value="{{ $santri->id }}"
                            {{ old('santri_id', $absensi->santri_id) == $santri->id ? 'selected' : '' }}>
                            {{ $santri->nis }} – {{ $santri->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal"
                    value="{{ old('tanggal', $absensi->tanggal->toDateString()) }}"
                    class="border rounded w-full p-2" required>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="border rounded w-full p-2" required>
                    <option value="" disabled>Pilih status</option>
                    <option value="hadir" {{ old('status', $absensi->status) === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin"  {{ old('status', $absensi->status) === 'izin'  ? 'selected' : '' }}>Izin</option>
                    <option value="alfa"  {{ old('status', $absensi->status) === 'alfa'  ? 'selected' : '' }}>Alfa</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Update
                </button>
                <a href="{{ route('absensi.index', ['tanggal' => $absensi->tanggal->toDateString()]) }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
