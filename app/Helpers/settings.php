<?php

use App\Services\SettingsService;

if (! function_exists('setting')) {
    /**
     * Helper to retrieve cached application settings.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingsService::class)->get($key, $default);
    }
}

