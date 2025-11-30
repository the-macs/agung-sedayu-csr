<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class AppearanceServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->registerColorScheme();
    }

    /**
     * Register custom color scheme from settings
     */
    protected function registerColorScheme(): void
    {
        try {
            $defaults = config('filament-appearance.defaults', []);

            FilamentColor::register([
                'primary' => Color::hex(setting('primary_color') ?? $defaults['primary_color'] ?? '#3b82f6'),
                'secondary' => Color::hex(setting('secondary_color') ?? $defaults['secondary_color'] ?? '#8b5cf6'),
                'success' => Color::hex(setting('success_color') ?? $defaults['success_color'] ?? '#10b981'),
                'warning' => Color::hex(setting('warning_color') ?? $defaults['warning_color'] ?? '#faff00'),
                'danger' => Color::hex(setting('danger_color') ?? $defaults['danger_color'] ?? '#ef4444'),
                'info' => Color::hex(setting('info_color') ?? $defaults['info_color'] ?? '#0ea5e9'),
            ]);
        } catch (\Exception $e) {
            logger()->warning('Failed to load color settings: ' . $e->getMessage());
        }
    }
}
