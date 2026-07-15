<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($header) ? strip_tags($header) . ' | ' : '' }}Sekolah App</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @include('layouts.theme-script')


        {{-- Favicon --}}
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22M3 9l9-7 9 7v11a2 2 0 0-1-2 2H5a2 2 0 0-1-2-2z%22/><path d=%22M9 22V12h6v10%22/></svg>">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            [x-cloak] { display: none !important; }
            #nprogress .bar { background: #06b6d4 !important; height: 3px !important; }
            #nprogress .peg { box-shadow: 0 0 10px #06b6d4, 0 0 5px #06b6d4 !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-slate-900">
        <div x-data="{
            sidebarOpen: false,
            touchStartX: 0,
            touchStartY: 0,
            handleSwipe(e) {
                if (e.type === 'touchstart') {
                    this.touchStartX = e.changedTouches[0].screenX;
                    this.touchStartY = e.changedTouches[0].screenY;
                }
                if (e.type === 'touchend') {
                    const diffX = e.changedTouches[0].screenX - this.touchStartX;
                    const diffY = Math.abs(e.changedTouches[0].screenY - this.touchStartY);
                    if (this.touchStartX < 50 && diffX > 100 && diffY < 50) this.sidebarOpen = true;
                }
            }
        }"
        :class="sidebarOpen ? 'overflow-hidden' : 'relative min-h-screen'"
        @touchstart="handleSwipe($event)"
        @touchend="handleSwipe($event)"
        class="bg-gray-100 dark:bg-gradient-to-br dark:from-slate-950 dark:to-slate-900">

            {{-- Liquid glass background blobs --}}
            <div class="pointer-events-none absolute inset-0 overflow-hidden opacity-0 dark:opacity-100" aria-hidden="true">
                <div class="absolute -left-48 -top-48 h-[700px] w-[700px] rounded-full bg-slate-500/10 blur-3xl "></div>
                <div class="absolute -bottom-48 -right-48 h-[700px] w-[700px] rounded-full bg-slate-600/10 blur-3xl"></div>
                <div class="absolute left-1/2 top-1/3 h-[500px] w-[500px] -translate-x-1/2 rounded-full bg-slate-400/10 blur-3xl"></div>
                <div class="absolute right-1/4 top-1/4 h-[400px] w-[400px] rounded-full bg-slate-500/5 blur-3xl"></div>
            </div>

            @auth
                @include('layouts.navigation')
            @endauth

            <div class="lg:pl-64">
                {{-- Navbar --}}
                <header class="sticky top-0 z-20 border-b bg-white/80 backdrop-blur-md dark:border-white/20 dark:bg-white/10 border-slate-200/80">
                    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center rounded-lg border p-2 transition lg:hidden border-slate-200/80 text-slate-600 hover:bg-slate-100/80 dark:border-white/20 dark:text-white/80 dark:hover:bg-white/10"
                                @click="sidebarOpen = true">
                                <span class="sr-only">Buka menu</span>
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>

                            <div class="text-slate-900 dark:text-white">
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
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200/50 dark:bg-white/20">
                                        <svg class="h-4 w-4 text-slate-600 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-white/90">{{ Auth::user()->name }}</span>
                                </div>

                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center rounded-lg border px-3 py-2 text-sm font-medium focus:outline-none transition border-slate-200/80 bg-white/50 text-slate-700 hover:bg-slate-100/80 dark:border-white/20 dark:bg-white/10 dark:text-white dark:hover:bg-white/20">
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
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Global delete confirmation with SweetAlert2
        document.querySelectorAll('.btn-delete').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var form = btn.closest('form');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Show SweetAlert2 success after a delete redirect
        @if (session('deleted'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('deleted') }}',
            icon: 'success',
            timer: 2500,
            showConfirmButton: false,
        });
        @endif
    });
    </script>
    </body>
</html>
