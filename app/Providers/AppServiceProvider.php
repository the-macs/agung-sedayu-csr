<?php

namespace App\Providers;

use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Route;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Force root URL - this is KEY for subdirectories
        app($this::class)->setScriptRoute(function ($handle) {
            return config('app.debug')
                ? Route::get('/csr-bedah-rumah/livewire/livewire.js', $handle)
                : Route::get('/csr-bedah-rumah/livewire/livewire.min.js', $handle);
        });

        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn(): string => '<style>
                .fi-sidebar {
                    background: #fff !important;
                }
                .dark .fi-sidebar {
                    background: #18181a !important;
                }
            </style>'
        );
    }
}
