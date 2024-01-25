<?php

namespace Hoomat\Notifications\App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotificationEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public $notification)
    {}
}
