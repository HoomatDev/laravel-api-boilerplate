<?php

namespace Hoomat\Notifications\App\Notifications;

use Hoomat\Notifications\App\Drivers\SmsChannel;
use Hoomat\Notifications\App\Drivers\SmsDriver;
use Hoomat\Notifications\App\Models\Notification as NotificationModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class PublicNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly NotificationModel $notif)
    {
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return array_map(function($item) {
            return match ($item) {
                'sms' => SmsChannel::class,
                'email' => MailChannel::class,
                'webpush' => WebPushChannel::class,
            };
        }, $this->notif->type);
    }


    public function toSms($notifiable)
    {
        return (new SmsDriver)
            ->to($notifiable->mobile)
            ->text($this->notif->text);
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->view(
            'emails.'.$this->notif->template->name,
            ['notification' => $this->notif]
        );
    }


    public function toWebPush($notifiable, $notification)
    {
//        $icon = '';
        $details = $this->notif->details;
        $image = $this->notif->getFileUrl('image');

        $message = (new WebPushMessage)
            ->body($this->notif->text);

        if (isset($details['action']) && is_array($details['action'])) {
            $message = $message->action($details['action'][0], $details['action'][1]);
        }

//        if ($icon !== '') {
//            $message = $message->icon($icon);
//        }

        if (isset($details['title'])) {
            $message = $message->title($details['title']);
        }

        if ($image && $image !== '') {
            $message = $message->image($image);
        }

        return $message;
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->notif->toArray();
    }
}
