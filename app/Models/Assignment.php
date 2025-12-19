<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'teacher_id',
        'school_id',
        'academic_class_id',
        'subject_id',
        'section_id',
        'title',
        'description',
        'instructions',
        'due_date',
        'max_marks',
        'attachment',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'max_marks' => 'integer',
        ];
    }

    /**
     * Get the teacher that created the assignment.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the school that owns the assignment.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the academic class for the assignment.
     */
    public function academicClass(): BelongsTo
    {
        return $this->belongsTo(AcademicClass::class);
    }

    /**
     * Get the subject for the assignment.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the section for the assignment.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
