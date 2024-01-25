<?php

namespace Hoomat\Notifications\App\Models;

use Hoomat\Base\App\Models\BaseModel;
use Hoomat\Filesystem\App\Traits\HasFile;
use Hoomat\Identities\App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $notifable_id
 * @property string $notifable_type
 * @property int $template_id
 * @property string $text
 * @property array $type - e.g. sms, email, webpush, in-app
 * @property mixed $send_at
 * @property ?array $details
 * @property ?int $sender_id
 * @property int $status - 1: pending, 2: canceled, 3: sent, 4: failed
 * @property NotificationTemplate $template
 * @property ?User $sentBy
 * @property NotificationLog[] $logs
 * @property User[] $receivers
 */
class Notification extends BaseModel
{
    use HasFile;

    protected $fillable = [
        'notifable_id',
        'notifable_type',
        'service_id',
        'template_id',
        'text',
        'type',
        'send_at',
        'details',
        'sender_id',
        'status'
    ];


    protected $casts = [
        'details' => 'array',
        'type' => 'array',
    ];


    public function notifable(): MorphTo
    {
        return $this->morphTo();
    }


    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }


    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id', 'id');
    }


    public function logs(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }


    public function receivers(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            NotificationLog::class,
            'notification_id',
            'id',
            'id',
            'receiver_id'
        );
    }
}
