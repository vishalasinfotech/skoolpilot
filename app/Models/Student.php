<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'school_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'parent_phone',
        'admission_number',
        'date_of_birth',
        'gender',
        'address',
        'class',
        'section',
        'roll_number',
        'admission_date',
        'parent_name',
        'parent_email',
        'blood_group',
        'profile_image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'admission_date' => 'date',
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
