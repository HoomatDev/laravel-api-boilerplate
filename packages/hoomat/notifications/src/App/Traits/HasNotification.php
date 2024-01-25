<?php

namespace Hoomat\Notifications\App\Traits;

use Hoomat\Notifications\App\Models\Notification;

trait HasNotification
{
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifable');
    }
}
