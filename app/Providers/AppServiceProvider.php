<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as RoutingRoute;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for all generated URLs when behind a tunnel
        if (env('APP_ENV') === 'production' || str_starts_with(env('APP_URL', ''), 'https://')) {
            URL::forceScheme('https');
        }

        RoutingRoute::macro('title', function (string $title) {
            $this->defaults['title'] = $title;
            return $this;
        });
    }
}
