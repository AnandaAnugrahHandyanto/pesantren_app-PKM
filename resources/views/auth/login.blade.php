<x-guest-layout>
    {{-- Heading --}}
    <div class="mb-6 text-center">
        <div class="mb-3 flex justify-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-white/20 bg-white/15 backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
        </div>
        <h1 class="text-xl font-bold text-white">Login Sistem Informasi Sekolah</h1>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white/80" />
            <x-text-input id="email"
                class="block mt-1 w-full border-white/20 bg-white/10 text-white placeholder-white/30 focus:border-indigo-400 focus:ring-indigo-400"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white/80" />

            <x-text-input id="password"
                class="block mt-1 w-full border-white/20 bg-white/10 text-white placeholder-white/30 focus:border-indigo-400 focus:ring-indigo-400"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-white/30 bg-white/10 text-indigo-500 shadow-sm focus:ring-indigo-400" name="remember">
                <span class="ms-2 text-sm text-white/60">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-white/50 underline hover:text-white/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-indigo-600 hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:ring-indigo-400">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

