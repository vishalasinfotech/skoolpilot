<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public static function get(string $key, $schoolId = null, $default = null)
    {
        $query = Setting::where('key', $key);

        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }

        return optional($query->latest()->first())->value ?? $default;
    }
}
