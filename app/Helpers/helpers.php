<?php

use App\Services\SettingService;

if (! function_exists('setting')) {
    /**
     * Get a setting value by key.
     *
     * @param  mixed  $schoolId
     * @param  mixed  $default
     * @return mixed
     */
    function setting(string $key, $schoolId = null, $default = null)
    {
        return SettingService::get($key, $schoolId, $default);
    }
}
