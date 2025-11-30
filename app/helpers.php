<?php

use App\Services\SettingService;

if (!function_exists('setting')) {
    function setting(?string $key = null, $default = null)
    {

        // 1. Static cache to check if the table existence has been determined this request
        static $tableExists = null;

        // 2. Perform the check and cache the result ONLY ONCE per request
        if ($tableExists === null) {
            $tableExists = Schema::hasTable('settings');
        }

        // 3. Use the cached result
        if (!$tableExists) {
            return $default;
        }

        if (is_null($key)) {
            return app(SettingService::class);
        }

        return (new SettingService())->get($key, $default);
    }
}

if (!function_exists('app_theme_mode')) {
    function app_theme_mode(): \Filament\Enums\ThemeMode
    {
        return match (setting('theme', 'light')) {
            'dark' => \Filament\Enums\ThemeMode::Dark,
            'system' => \Filament\Enums\ThemeMode::System,
            default => \Filament\Enums\ThemeMode::Light,
        };
    }
}

if (!function_exists('app_sidebar_width')) {
    function app_sidebar_width(): string
    {
        return match (setting('sidebar_width', 'normal')) {
            'compact' => '15rem',
            'wide' => '20rem',
            default => '17rem',
        };
    }
}

if (!function_exists('app_container_width')) {
    function app_container_width(): \Filament\Support\Enums\Width
    {
        return match (setting('container_width', 'default')) {
            'full' => \Filament\Support\Enums\Width::Full,
            'md' => \Filament\Support\Enums\Width::ScreenMedium,
            'lg' => \Filament\Support\Enums\Width::ScreenLarge,
            '2xl' => \Filament\Support\Enums\Width::ScreenTwoExtraLarge,
            default => \Filament\Support\Enums\Width::ScreenExtraLarge,
        };
    }
}
