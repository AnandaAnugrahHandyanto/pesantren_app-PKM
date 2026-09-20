<header class="sticky top-0 z-20 border-b border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/10 backdrop-blur-md">
    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-white/20 p-2 text-slate-900 dark:text-slate-700 dark:text-white/80 hover:bg-slate-50 dark:bg-white/10 transition lg:hidden"
                @click="sidebarOpen = true"
            >
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
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 py-1.5 pl-3 pr-4 text-sm font-medium text-slate-900 dark:text-white hover:bg-slate-50 dark:bg-white/10 transition">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-cyan-500/20 text-cyan-300">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        {{ Auth::user()->name }}
                        <svg class="h-4 w-4 text-slate-900 dark:text-slate-500 dark:text-white/50" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-2 border-b border-slate-200 dark:border-white/10">
                        <p class="text-xs text-slate-900 dark:text-slate-500 dark:text-white/50">Masuk sebagai</p>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:text-slate-900 dark:text-white hover:bg-white dark:bg-white/5">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400 hover:text-red-300 hover:bg-white dark:bg-white/5">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        @endauth
    </div>
</header>
