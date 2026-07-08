<?php

if (!function_exists('routeTitle')) {
    function routeTitle(?string $default = null): string
    {
        return Route::current()?->defaults['title']
            ?? $default
            ?? config('app.name');
    }
}
