<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="space-y-6">
            {{-- Profile Update Section --}}
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Password Update Section --}}
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account Section --}}
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
