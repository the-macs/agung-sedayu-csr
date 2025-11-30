<?php

namespace App\Providers;

use App\Services\SettingService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('settings', function ($app) {
            return $app->make(SettingService::class);
        });
    }

    public function boot(): void
    {
        if ($this->shouldLoadSettings()) {
            $this->loadApplicationSettings();
        }
    }

    private function shouldLoadSettings(): bool
    {
        if ($this->app->runningInConsole() && !$this->app->runningUnitTests()) {
            return false;
        }

        try {
            return Schema::hasTable('settings');
        } catch (\Exception $e) {
            return false;
        }
    }

    private function loadApplicationSettings(): void
    {
        try {
            $settings = app(SettingService::class);

            $this->applyTimezoneSettings($settings);
            $this->applyFormatSettings($settings);
            $this->applySystemSettings($settings);

        } catch (\Exception $e) {
            logger()->error('Failed to load application settings: ' . $e->getMessage());
        }
    }

    private function applyTimezoneSettings(SettingService $settings): void
    {
        if ($timezone = $settings->get('timezone')) {
            Config::set('app.timezone', $timezone);
            date_default_timezone_set($timezone);
        }
    }

    private function applyFormatSettings(SettingService $settings): void
    {
        $dateFormat = $settings->get('date_format', 'Y-m-d');
        $timeFormat = $settings->get('time_format', 'H:i:s');

        Config::set('formats.date', $dateFormat);
        Config::set('formats.time', $timeFormat);
        Config::set('formats.datetime', "$dateFormat $timeFormat");
    }

    private function applySystemSettings(SettingService $settings): void
    {
        // Apply Maintenance Mode
        $maintenanceMode = $settings->get('maintenance_mode', false);
        $this->applyMaintenanceMode($maintenanceMode);

        // Apply Debug Mode (only in non-production)
        if (!app()->environment('production')) {
            $debugMode = $settings->get('debug_mode', false);
            Config::set('app.debug', (bool)$debugMode);
        }

        // Session lifetime
        if ($sessionLifetime = $settings->get('session_lifetime')) {
            Config::set('session.lifetime', (int)$sessionLifetime);
        }
    }

    private function applyMaintenanceMode(bool $enabled): void
    {
        // Just store the setting - we'll handle it in middleware
        cache()->put('app.maintenance_mode', $enabled, now()->addYear());
    }
}
