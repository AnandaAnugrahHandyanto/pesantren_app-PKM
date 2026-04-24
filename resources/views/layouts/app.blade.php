<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="relative min-h-screen overflow-hidden bg-gradient-to-br from-blue-950 via-indigo-950 to-cyan-950">
            {{-- Liquid glass background blobs --}}
            <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
                <div class="absolute -left-48 -top-48 h-[700px] w-[700px] rounded-full bg-blue-500/20 blur-3xl"></div>
                <div class="absolute -bottom-48 -right-48 h-[700px] w-[700px] rounded-full bg-purple-500/20 blur-3xl"></div>
                <div class="absolute left-1/2 top-1/3 h-[500px] w-[500px] -translate-x-1/2 rounded-full bg-cyan-400/15 blur-3xl"></div>
                <div class="absolute right-1/4 top-1/4 h-[400px] w-[400px] rounded-full bg-indigo-400/10 blur-3xl"></div>
            </div>

            @auth
                @include('layouts.navigation')
            @endauth

            <div class="lg:pl-64">
                {{-- Navbar --}}
                <header class="sticky top-0 z-20 border-b border-white/20 bg-white/10 backdrop-blur-md">
                    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center rounded-lg border border-white/20 p-2 text-white/80 hover:bg-white/10 transition lg:hidden"
                                @click="sidebarOpen = true"
                            >
                                <span class="sr-only">Buka menu</span>
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>

                            <div class="text-white">
                                @isset($header)
                                    {{ $header }}
                                @else
                                    <h1 class="text-lg font-semibold">Dashboard</h1>
                                @endisset
                            </div>
                        </div>

                        @auth
                            <div class="flex items-center gap-3">
                                <div class="hidden sm:flex items-center gap-2">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20">
                                        <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-white/90">{{ Auth::user()->name }}</span>
                                </div>

                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center rounded-lg border border-white/20 bg-white/10 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 focus:outline-none transition">
                                            Akun
                                            <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endauth
                    </div>
                </header>

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
