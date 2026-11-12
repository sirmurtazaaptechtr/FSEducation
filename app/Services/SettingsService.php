<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    public const CACHE_KEY = 'app_settings_all';

    /**
     * Retrieve all settings as key => value array, cached indefinitely.
     */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            try {
                return Setting::pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    /**
     * Get a specific setting value.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    /**
     * Set a setting value and invalidate cache.
     */
    public function set(string $key, mixed $value, string $group = 'General'): Setting
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        $this->clearCache();

        return $setting;
    }

    /**
     * Update multiple settings and invalidate cache.
     */
    public function updateMany(array $settings, ?string $defaultGroup = null): void
    {
        foreach ($settings as $key => $value) {
            $existing = Setting::where('key', $key)->first();
            $group = $existing ? $existing->group : ($defaultGroup ?? 'General');

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }

        $this->clearCache();
    }

    /**
     * Get all settings grouped by group name.
     */
    public function getAllByGroup(): array
    {
        $records = Setting::all();
        $grouped = [];

        foreach ($records as $record) {
            $grouped[$record->group][$record->key] = $record->value;
        }

        return $grouped;
    }

    /**
     * Invalidate the settings cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
