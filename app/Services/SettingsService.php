<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    protected const CACHE_KEY = 'app_settings_all';

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
     * Invalidate the settings cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
