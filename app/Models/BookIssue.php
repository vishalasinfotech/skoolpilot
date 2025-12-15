<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookIssue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'library_id',
        'user_id',
        'issue_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
            'return_date' => 'date',
        ];
    }

    /**
     * Get the school that owns the book issue.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the library book that was issued.
     */
    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    /**
     * Get the user (student/staff) who was issued the book.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
