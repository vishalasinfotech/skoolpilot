<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;

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

    public function schools(): HasMany
    {
        return $this->hasMany(School::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
