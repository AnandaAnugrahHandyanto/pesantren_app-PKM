<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>404 — Halaman Tidak Ditemukan | {{ config('app.name', 'Sekolah App') }}</title>

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
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg border border-white/20 bg-white/15">
                        <svg class="h-4 w-4 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="text-base font-bold tracking-tight text-white">Sekolah App</span>
                </a>
            </div>
        </nav>

        {{-- 404 Content --}}
        <main class="relative z-10 mx-auto flex min-h-[calc(100vh-4rem)] max-w-6xl flex-col items-center justify-center px-4 py-16 text-center sm:px-6">

            {{-- Icon tanda tanya --}}
            <div class="mb-5 flex justify-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-white/20 bg-gradient-to-br from-indigo-500/20 to-blue-500/20 shadow-xl shadow-indigo-500/10 backdrop-blur-xl">
                    <svg class="h-8 w-8 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
            </div>

            {{-- 404 Number --}}
            <div class="select-none">
                <span class="font-extrabold leading-none tracking-tighter"
                      style="font-size: clamp(5rem, 18vw, 11rem); background: linear-gradient(to right, #67e8f9, #93c5fd, #a5b4fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    404
                </span>
            </div>

            {{-- Headline — proporsional dengan angka 404 --}}
            <h1 class="mt-3 font-extrabold tracking-tight text-white"
                style="font-size: clamp(1.25rem, 4.5vw, 3rem);">
                Halaman Tidak Ditemukan
            </h1>

            {{-- CTA Buttons --}}
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ url('/') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-3.5 text-sm font-semibold text-white shadow-xl shadow-indigo-500/30 transition hover:from-indigo-500 hover:to-blue-500 hover:shadow-indigo-500/40 active:scale-[0.98]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Kembali ke Beranda
                </a>

                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/10 px-8 py-3.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20 active:scale-[0.98]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Buka Dashboard
                    </a>
                @endauth
            </div>

            {{-- Footer --}}
            <p class="mt-16 text-xs text-white/30">
                &copy; {{ date('Y') }} Sekolah App. All rights reserved.
            </p>
        </main>
    </div>
</body>
</html>
