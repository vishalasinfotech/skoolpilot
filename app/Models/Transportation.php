<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transportation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'vehicle_number',
        'vehicle_type',
        'driver_name',
        'driver_phone',
        'driver_license_number',
        'capacity',
        'route_name',
        'route_description',
        'fare_amount',
        'registration_date',
        'insurance_expiry',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'fare_amount' => 'decimal:2',
            'registration_date' => 'date',
            'insurance_expiry' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the school that owns the transportation.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
