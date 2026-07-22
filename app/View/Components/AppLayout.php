<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AppLayout extends Component
{
    public $title;
    public $breadcrumb;

    public function __construct($title = null, $breadcrumb = null)
    {
        $routeName = request()->route()->getName();
        $role = Auth::check() ? Auth::user()->role : 'guest';
        $navConfig = config("navigation.{$role}");

        // Logic to infer key based on route name pattern
        $resourceKey = 'dashboard';
        $actionKey = 'index';

        if ($routeName !== 'dashboard' && !in_array($routeName, ['admin.dashboard', 'guru.dashboard', 'siswa.dashboard'])) {
            $parts = explode('.', $routeName);
            
            // Remove role prefix if it exists to isolate the resource and action
            if (isset($parts[0]) && $parts[0] === $role) {
                array_shift($parts);
            }
            
            if (count($parts) > 0 && $parts[0] !== 'dashboard') {
                $resourceKey = $parts[0];
                $actionPart = $parts[1] ?? 'index';

                if (in_array($actionPart, ['create', 'store'])) {
                    $actionKey = 'create';
                } elseif (in_array($actionPart, ['edit', 'update'])) {
                    $actionKey = 'edit';
                } elseif (in_array($actionPart, ['show'])) {
                    $actionKey = 'show';
                } else {
                    $actionKey = 'index';
                    // Handle special case for 'laporan.absensi'
                    if ($resourceKey === 'laporan' && isset($parts[1])) {
                        $actionKey = $parts[1]; // e.g., 'absensi'
                    }
                }
            }
        }
        
        if ($navConfig && isset($navConfig[$resourceKey][$actionKey])) {
            $this->title = $title ?? $navConfig[$resourceKey][$actionKey]['title'];
            $this->breadcrumb = $breadcrumb ?? $navConfig[$resourceKey][$actionKey]['breadcrumb'];
        } else {
            // Fallback
            $this->title = $title ?? \Illuminate\Support\Str::title(str_replace(['.', '_', '-'], ' ', $routeName));
            $this->breadcrumb = $breadcrumb ?? 'Home > ' . \Illuminate\Support\Str::title(str_replace('.', ' > ', $routeName));
        }
    }

    public function render(): View
    {
        return view('layouts.app', [
            'title' => $this->title,
            'breadcrumb' => $this->breadcrumb
        ]);
    }
}
