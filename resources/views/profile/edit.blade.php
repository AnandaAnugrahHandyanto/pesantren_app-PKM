<x-app-layout>

    <div class="py-12">
        <div class="space-y-6">
            {{-- Profile Update Section --}}
            <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 p-6 backdrop-blur-xl">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Password Update Section --}}
            <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 p-6 backdrop-blur-xl">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account Section --}}
            <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 p-6 backdrop-blur-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
