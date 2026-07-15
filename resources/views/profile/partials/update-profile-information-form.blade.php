<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-900 dark:text-slate-600 dark:text-white/70">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-slate-900 dark:text-white font-medium" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-slate-50 dark:bg-white/10 border-slate-300 dark:border-white/20 text-slate-900 dark:text-white placeholder-white/40 focus:border-cyan-500 focus:ring-cyan-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-900 dark:text-white font-medium" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-slate-50 dark:bg-white/10 border-slate-300 dark:border-white/20 text-slate-900 dark:text-white placeholder-white/40 focus:border-cyan-500 focus:ring-cyan-500" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-cyan-600 hover:bg-cyan-500 text-slate-900 dark:text-white shadow-lg shadow-cyan-900/20">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-cyan-300"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
