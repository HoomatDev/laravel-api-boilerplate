<?php

namespace Hoomat\Notifications\Providers;

use Hoomat\Notifications\App\Events\NewNotificationEvent;
use Hoomat\Notifications\App\Listeners\NewNotificationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class NotificationEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        NewNotificationEvent::class => [
            NewNotificationListener::class,
        ],
    ];


    public function boot(): void
    {
        parent::boot();
    }
}
