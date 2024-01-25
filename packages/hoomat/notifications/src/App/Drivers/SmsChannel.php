<?php

namespace Hoomat\Notifications\App\Drivers;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send(mixed $notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        $message->send();
    }
}
