<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'tier',
        'plan_status',
        'price',
        'offer_price',
        'features',
        'trial_days',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'price' => 'decimal:2',
            'offer_price' => 'decimal:2',
            'trial_days' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
