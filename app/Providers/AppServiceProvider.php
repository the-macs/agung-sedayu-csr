<?php

namespace App\Providers;

use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Request;

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

        $checkValidSignature = (config('app.env') === 'production' && str_contains(URL::current(), 'livewire/upload-file'));
        $checkValidSignatureTemporary = (config('app.env') === 'production' && str_contains(URL::current(), 'livewire/preview-file'));

        Request::macro('hasValidSignature', function ($absolute = true) use ($checkValidSignature, $checkValidSignatureTemporary) {
            if ($checkValidSignature || $checkValidSignatureTemporary) {
                return true;
            }
            return URL::hasValidSignature($this, $absolute);
        });

        Request::macro('hasValidRelativeSignature', function ()  use ($checkValidSignature, $checkValidSignatureTemporary) {
            if ($checkValidSignature || $checkValidSignatureTemporary) {
                return true;
            }
            return URL::hasValidSignature($this, $absolute = false);
        });

        Request::macro('hasValidSignatureWhileIgnoring', function ($ignoreQuery = [], $absolute = true)   use ($checkValidSignature, $checkValidSignatureTemporary) {
            if ($checkValidSignature || $checkValidSignatureTemporary) {
                return true;
            }
            return URL::hasValidSignature($this, $absolute, $ignoreQuery);
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
