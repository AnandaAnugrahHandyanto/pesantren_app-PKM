<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Total Santri --}}
                <div class="bg-white rounded-lg shadow p-6 flex items-center gap-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Santri</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalSantri }}</p>
                    </div>
                </div>

                {{-- Hadir Hari Ini --}}
                <div class="bg-white rounded-lg shadow p-6 flex items-center gap-4">
                    <div class="bg-green-100 text-green-600 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Hadir Hari Ini</p>
                        <p class="text-2xl font-bold text-green-600">{{ $hadir }}</p>
                    </div>
                </div>

                {{-- Izin Hari Ini --}}
                <div class="bg-white rounded-lg shadow p-6 flex items-center gap-4">
                    <div class="bg-yellow-100 text-yellow-600 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Izin Hari Ini</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $izin }}</p>
                    </div>
                </div>

                {{-- Alfa Hari Ini --}}
                <div class="bg-white rounded-lg shadow p-6 flex items-center gap-4">
                    <div class="bg-red-100 text-red-600 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Alfa Hari Ini</p>
                        <p class="text-2xl font-bold text-red-600">{{ $alfa }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
