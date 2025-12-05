<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'school_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'employee_id',
        'date_of_birth',
        'gender',
        'address',
        'qualification',
        'specialization',
        'joining_date',
        'salary',
        'profile_image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'joining_date' => 'date',
            'salary' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
