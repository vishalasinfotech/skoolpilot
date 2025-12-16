<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'native_name',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active languages.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include default language.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get the default language code.
     */
    public static function getDefaultCode(): string
    {
        $default = static::where('is_default', true)
            ->where('is_active', true)
            ->first();

        return $default ? $default->code : 'en';
    }

    /**
     * Set this language as default.
     */
    public function setAsDefault(): void
    {
        // Remove default from all languages
        static::where('is_default', true)->update(['is_default' => false]);

        // Set this as default
        $this->update(['is_default' => true, 'is_active' => true]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(): void
    {
        if ($this->is_default && $this->is_active) {
            return; // Cannot deactivate default language
        }

        $this->update(['is_active' => ! $this->is_active]);
    }
}
