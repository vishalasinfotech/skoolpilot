<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'logo',
        'theme_color',
        'status',
        'subscription_plan_id',
        'trial_ends_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'trial_ends_at' => 'datetime',
        ];
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
