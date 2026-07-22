<x-app-layout :title="__('Pengaturan Akun')" :breadcrumb="__('Profil > Pengaturan Akun')">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Informasi Profil --}}
            <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-800 p-6 shadow-sm">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Ubah Password --}}
            <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-800 p-6 shadow-sm">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Sesi Aktif --}}
            <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-800 p-6 shadow-sm">
                @include('profile.partials.active-sessions-form')
            </div>

            {{-- Delete Account Section --}}
            <div class="rounded-2xl border border-red-200 dark:border-red-900/30 bg-white dark:bg-slate-800 p-6 shadow-sm">
                <div class="text-red-600 dark:text-red-400 mb-4 font-medium">{{ __('Bahaya') }}</div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
