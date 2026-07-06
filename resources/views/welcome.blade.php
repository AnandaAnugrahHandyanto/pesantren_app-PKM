<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistem Informasi Manajemen Sekolah</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

        <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-blue-950 via-indigo-950 to-cyan-950">

            {{-- Background blobs --}}
            <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
                <div class="absolute -left-48 -top-48 h-[700px] w-[700px] rounded-full bg-blue-500/20 blur-3xl"></div>
                <div class="absolute -bottom-48 -right-48 h-[700px] w-[700px] rounded-full bg-purple-500/20 blur-3xl"></div>
                <div class="absolute left-1/2 top-1/3 h-[500px] w-[500px] -translate-x-1/2 rounded-full bg-cyan-400/15 blur-3xl"></div>
                <div class="absolute right-1/4 top-1/4 h-[400px] w-[400px] rounded-full bg-indigo-400/10 blur-3xl"></div>
            </div>

            {{-- Main content --}}
            <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12">

                {{-- Hero card --}}
                <div class="w-full max-w-lg rounded-2xl border border-white/20 bg-white/10 p-8 shadow-2xl backdrop-blur-xl sm:p-10">

                    {{-- Icon --}}
                    <div class="mb-6 flex justify-center">
                        <div class="flex h-20 w-20 items-center justify-center rounded-2xl border border-white/20 bg-white/15 shadow-lg backdrop-blur-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-cyan-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                    </div>

                    {{-- Heading --}}
                    <div class="mb-2 text-center">
                        <h1 class="text-2xl font-bold leading-tight text-white sm:text-3xl">
                            Sistem Informasi Manajemen Sekolah
                        </h1>
                    </div>

                    {{-- Subheading --}}
                    <p class="mb-8 text-center text-sm leading-relaxed text-white/60 sm:text-base">
                        Aplikasi untuk pengelolaan data siswa dan absensi sekolah
                    </p>

                    {{-- Action buttons --}}
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('login') }}"
                           class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Masuk
                        </a>

                        <a href="{{ route('register') }}"
                           class="flex flex-1 items-center justify-center gap-2 rounded-xl border border-white/25 bg-white/10 px-6 py-3 text-sm font-semibold text-white shadow-lg backdrop-blur-md transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/30 focus:ring-offset-2 focus:ring-offset-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Daftar
                        </a>
                    </div>
                </div>

                {{-- Feature cards --}}
                <div class="mt-8 grid w-full max-w-lg grid-cols-1 gap-4 sm:grid-cols-3">
                    {{-- Data Siswa --}}
                    <div class="flex flex-col items-center gap-2 rounded-2xl border border-white/15 bg-white/8 p-4 text-center backdrop-blur-md">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/30 text-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-white">Data Siswa</p>
                        <p class="text-xs text-white/50">Kelola data siswa dengan mudah</p>
                    </div>

                    {{-- Absensi --}}
                    <div class="flex flex-col items-center gap-2 rounded-2xl border border-white/15 bg-white/8 p-4 text-center backdrop-blur-md">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/30 text-green-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-white">Absensi</p>
                        <p class="text-xs text-white/50">Catat kehadiran siswa harian</p>
                    </div>

                    {{-- Laporan --}}
                    <div class="flex flex-col items-center gap-2 rounded-2xl border border-white/15 bg-white/8 p-4 text-center backdrop-blur-md">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/30 text-indigo-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18"/>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-white">Laporan</p>
                        <p class="text-xs text-white/50">Rekapitulasi data absensi</p>
                    </div>
                </div>

                {{-- Footer --}}
                <p class="mt-8 text-xs text-white/30">
                    &copy; {{ date('Y') }} Sekolah App &mdash; Sistem Informasi Manajemen Sekolah
                </p>

            </div>
        </div>

    </body>
</html>
