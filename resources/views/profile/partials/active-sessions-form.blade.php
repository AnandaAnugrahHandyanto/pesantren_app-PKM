<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Sesi Aktif') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ __('Berikut adalah daftar perangkat yang sedang menggunakan akun Anda.') }}
        </p>
    </header>

    <div class="mt-6 space-y-4">
        @forelse ($sessions as $session)
            @php
                $ua = $session->user_agent;
                $browser = 'Perangkat Tidak Dikenal';
                $os = '';

                if (\Illuminate\Support\Str::contains($ua, 'Firefox')) $browser = 'Firefox';
                elseif (\Illuminate\Support\Str::contains($ua, 'Edge')) $browser = 'Edge';
                elseif (\Illuminate\Support\Str::contains($ua, 'Chrome')) $browser = 'Chrome';
                elseif (\Illuminate\Support\Str::contains($ua, 'Safari')) $browser = 'Safari';

                if (\Illuminate\Support\Str::contains($ua, 'Android')) $os = 'Android';
                elseif (\Illuminate\Support\Str::contains($ua, 'iPhone')) $os = 'iOS';
                elseif (\Illuminate\Support\Str::contains($ua, 'Windows')) $os = 'Windows';
                elseif (\Illuminate\Support\Str::contains($ua, 'Mac')) $os = 'macOS';
                elseif (\Illuminate\Support\Str::contains($ua, 'Linux')) $os = 'Linux';
            @endphp
            <div class="flex items-center justify-between p-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-slate-100 dark:bg-slate-800 rounded-full text-slate-500 dark:text-slate-300">
                        <i data-lucide="{{ $os === 'Android' || $os === 'iOS' ? 'smartphone' : 'monitor' }}" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100">
                            {{ $browser }} di {{ $os ?: 'Perangkat Tidak Dikenal' }}
                            @if ($session->id === request()->session()->getId())
                                <span class="ml-2 text-xs text-emerald-600 dark:text-emerald-400 font-semibold">{{ __('(Sesi Saat Ini)') }}</span>
                            @endif
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            IP: {{ $session->ip_address }}
                        </p>
                        <p class="text-xs text-slate-400 mt-1">
                            {{ __('Terakhir aktif: ') }} {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->locale('id')->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Tidak ada sesi aktif ditemukan.') }}</p>
        @endforelse
    </div>
</section>
