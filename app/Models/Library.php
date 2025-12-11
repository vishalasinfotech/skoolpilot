<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Library extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'book_title',
        'isbn',
        'author',
        'publisher',
        'category',
        'total_copies',
        'available_copies',
        'price',
        'purchase_date',
        'description',
        'book_image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'total_copies' => 'integer',
            'available_copies' => 'integer',
            'price' => 'decimal:2',
            'purchase_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the school that owns the library book.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
