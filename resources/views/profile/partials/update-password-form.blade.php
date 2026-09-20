<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-900 dark:text-slate-500 dark:text-white/60">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-slate-900 dark:text-white font-medium" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-slate-50 dark:bg-white/10 border-slate-300 dark:border-white/20 text-slate-900 dark:text-white placeholder-white/40 focus:border-cyan-500 focus:ring-cyan-500" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-400" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-slate-900 dark:text-white font-medium" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-slate-50 dark:bg-white/10 border-slate-300 dark:border-white/20 text-slate-900 dark:text-white placeholder-white/40 focus:border-cyan-500 focus:ring-cyan-500" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-400" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-slate-900 dark:text-white font-medium" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-slate-50 dark:bg-white/10 border-slate-300 dark:border-white/20 text-slate-900 dark:text-white placeholder-white/40 focus:border-cyan-500 focus:ring-cyan-500" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-cyan-600 hover:bg-cyan-500 text-slate-900 dark:text-white shadow-lg shadow-cyan-900/20">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
