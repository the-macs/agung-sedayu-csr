<?php

namespace App\Providers;

use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Livewire\Livewire;

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

        Livewire::setUpdateRoute(function ($handle) {
            return '/csr-bedah-rumah/livewire/update';
        });

        Livewire::setScriptRoute(function () {
            return '/csr-bedah-rumah/livewire/livewire.js';
        });

        Livewire::setAssetBaseUrl(url('/csr-bedah-rumah/livewire'));

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
