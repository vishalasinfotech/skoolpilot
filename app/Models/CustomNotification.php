<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomNotification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id',
        'notification_template_id',
        'sender_id',
        'title',
        'message',
        'type',
        'recipient_roles',
        'recipient_user_ids',
        'total_recipients',
        'emails_sent',
        'emails_failed',
        'url',
        'email_sent',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'recipient_roles' => 'array',
            'recipient_user_ids' => 'array',
            'email_sent' => 'boolean',
            'sent_at' => 'datetime',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(NotificationRecipient::class, 'notification_id');
    }
}
