<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sekolah App') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
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

        <div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">

                {{-- Back link --}}
                <a href="{{ url('/') }}" class="group mb-8 inline-flex items-center gap-1.5 text-sm text-white/40 transition hover:text-white/70">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Beranda
                </a>

                {{-- Glass card --}}
                <div class="rounded-2xl border border-white/20 bg-white/10 px-8 py-8 shadow-xl backdrop-blur-md sm:px-10">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                <p class="mt-6 text-center text-xs text-white/30">
                    &copy; {{ date('Y') }} Sekolah App. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
