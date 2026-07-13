<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sekolah App') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-blue-950 via-indigo-950 to-cyan-950">

        {{-- Background blobs --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute -left-48 -top-48 h-[800px] w-[800px] rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute -bottom-48 -right-48 h-[800px] w-[800px] rounded-full bg-purple-500/20 blur-3xl"></div>
            <div class="absolute left-1/2 top-1/4 h-[600px] w-[600px] -translate-x-1/2 rounded-full bg-cyan-400/15 blur-3xl"></div>
            <div class="absolute right-1/4 bottom-1/4 h-[400px] w-[400px] rounded-full bg-indigo-400/10 blur-3xl"></div>
        </div>

        {{-- Navbar --}}
        <nav class="relative z-20 border-b border-white/10">
            <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg border border-white/20 bg-white/15">
                        <svg class="h-4 w-4 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="text-base font-bold tracking-tight text-white">Sekolah App</span>
                </div>
                <div class="flex items-center gap-3">
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <main class="relative z-10 mx-auto flex min-h-[calc(100vh-4rem)] max-w-6xl flex-col items-center justify-center px-4 py-16 text-center sm:px-6">
            {{-- Brand icon --}}
            <div class="mb-8 flex justify-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-3xl border border-white/20 bg-gradient-to-br from-blue-500/20 to-indigo-500/20 shadow-2xl shadow-indigo-500/20 backdrop-blur-xl sm:h-24 sm:w-24">
                    <svg class="h-10 w-10 text-cyan-300 sm:h-12 sm:w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>

            {{-- Headline --}}
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Sistem Informasi<br>
                <span class="bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">Sekolah App</span>
            </h1>

            <p class="mt-6 max-w-lg text-base leading-relaxed text-white/60 sm:text-lg">
                Kelola absensi, data siswa, dan laporan sekolah dengan mudah
                dan efisien dalam satu platform terpadu.
            </p>

            {{-- CTA Buttons --}}
            <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                @guest
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-3.5 text-sm font-semibold text-white shadow-xl shadow-indigo-500/30 transition hover:from-indigo-500 hover:to-blue-500 hover:shadow-indigo-500/40 active:scale-[0.98]">
                        Mulai Sekarang
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-3.5 text-sm font-semibold text-white shadow-xl shadow-indigo-500/30 transition hover:from-indigo-500 hover:to-blue-500 active:scale-[0.98]">
                    Buka Dashboard
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                    </a>
                @endguest
            </div>

            {{-- Features --}}
            <div class="mt-20 grid w-full gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 text-left backdrop-blur-sm">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/20 text-emerald-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Absensi Cepat</h3>
                    <p class="mt-1 text-xs text-white/50">Input absensi siswa massal dengan sekali klik. Multi-status: Hadir, Izin, Sakit, Alfa.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 text-left backdrop-blur-sm">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/20 text-blue-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Data Siswa</h3>
                    <p class="mt-1 text-xs text-white/50">Kelola data siswa lengkap dengan import Excel. NIS auto-generate.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 text-left backdrop-blur-sm">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-purple-500/20 text-purple-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M3 17h18" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Laporan Lengkap</h3>
                    <p class="mt-1 text-xs text-white/50">Rekap absensi harian & semester otomatis. Cetak laporan siap pakai.</p>
                </div>
            </div>

            {{-- Footer --}}
            <p class="mt-16 text-xs text-white/30">
                &copy; {{ date('Y') }} Sekolah App. All rights reserved.
            </p>
        </main>
    </div>
</body>
</html>
