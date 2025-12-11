<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $fillable = [
        'school_id',
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /**
     * Get the school that owns the setting.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null, ?int $schoolId = null)
    {
        $schoolId = $schoolId ?? auth()->user()?->school_id;

        $setting = static::where('key', $key)
            ->when($schoolId, function ($q) use ($schoolId) {
                return $q->where(function ($query) use ($schoolId) {
                    $query->where('school_id', $schoolId)
                        ->orWhereNull('school_id');
                });
            })
            ->orderByDesc('school_id') // Prefer school-specific over global
            ->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, $value, ?int $schoolId = null, string $type = 'string', string $group = 'general'): void
    {
        $schoolId = $schoolId ?? auth()->user()?->school_id;

        static::updateOrCreate(
            [
                'key' => $key,
                'school_id' => $schoolId,
            ],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
                'type' => $type,
                'group' => $group,
            ]
        );
    }
}
