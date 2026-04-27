<x-guest-layout>
    {{-- Heading --}}
    <div class="mb-6 text-center">
        <div class="mb-3 flex justify-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-white/20 bg-white/15 backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
        </div>
        <h1 class="text-xl font-bold text-white">Registrasi Akun Guru</h1>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white/80" />
            <x-text-input id="name"
                class="block mt-1 w-full border-white/20 bg-white/10 text-white placeholder-white/30 focus:border-indigo-400 focus:ring-indigo-400"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-white/80" />
            <x-text-input id="email"
                class="block mt-1 w-full border-white/20 bg-white/10 text-white placeholder-white/30 focus:border-indigo-400 focus:ring-indigo-400"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white/80" />

            <x-text-input id="password"
                class="block mt-1 w-full border-white/20 bg-white/10 text-white placeholder-white/30 focus:border-indigo-400 focus:ring-indigo-400"
                type="password"
                name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white/80" />

            <x-text-input id="password_confirmation"
                class="block mt-1 w-full border-white/20 bg-white/10 text-white placeholder-white/30 focus:border-indigo-400 focus:ring-indigo-400"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm text-white/50 underline hover:text-white/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-indigo-600 hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:ring-indigo-400">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

