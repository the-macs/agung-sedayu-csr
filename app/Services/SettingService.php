<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService extends BaseService
{
    /**
     * Defined Dependencies for this Service
     *
     */
    public function __construct()
    {
        $this->model = new Setting();
    }

    /**
     * Get a setting value from database with caching
     *
     * @param string $key
     * @param string|int|null $defaultValue
     * @return mixed
     */
    public function get(string $key, string|int $defaultValue = null): mixed
    {
        return Cache::remember("setting.$key", 3600, function () use ($key, $defaultValue) {

            $setting = static::query()->where('key', $key)->first();

            if (!$setting) {
                return $defaultValue;
            }

            return $this->castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value in database
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return void
     */
    public function set(string $key, mixed $value, string $type = 'string'): void
    {
        $processedValue = is_array($value) ? json_encode($value) : $value;

        $this->query()->updateOrCreate(
            ['key' => $key],
            [
                'value' => $processedValue,
                'type' => $type
            ]
        );

        // Clear cache for this setting
        Cache::forget("setting.$key");
    }

    /**
     * Get all settings as array
     *
     * @return array
     */
    public function all(): array
    {
        $settings = $this->getAllData(['key as setting_key', 'value', 'type']);
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->setting_key] = $this->castValue($setting->value, $setting->type);
        }

        return $result;
    }

    /**
     * Get the cast type
     *
     * @param [type] $value
     * @param [type] $type
     * @return void
     */
    public function castValue($value, $type)
    {
        return match ($type) {
            'boolean' => (bool) $value,
            'integer' => (int) $value,
            'float' => (float) $value,
            'array', 'json' => ($decoded = json_decode($value, true)) !== null ? $decoded : [],
            default => $value,
        };
    }

    /**
     * Clear all settings cache
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
