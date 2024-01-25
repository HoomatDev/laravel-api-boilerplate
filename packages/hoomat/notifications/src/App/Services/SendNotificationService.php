<?php

namespace Hoomat\Notifications\App\Services;

use Hoomat\Filesystem\App\Facades\Uploader;
use Hoomat\Notifications\App\Events\NewNotificationEvent;
use Hoomat\Notifications\App\Models\DTOs\NotificationDTO;
use Hoomat\Notifications\App\Services\NotificationTemplateService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendNotificationService
{
    private $template = null;
    private $notifable = null;
    private ?string $text = null;
    private ?array $details = null;
    private ?array $type = ['sms', 'email', 'webpush', 'in-app'];
    private $send_at = null;
    private array $receivers = [];
    private $image = null;


    public function __construct(
        private readonly NotificationService         $notificationService,
        private readonly NotificationTemplateService $templateService,
        private readonly NotificationLogService      $logService
    )
    {}


    public function send(): bool
    {
        try {
            DB::beginTransaction();

            $notif = $this->notificationService->create(new NotificationDTO(
                notifable_id: $this->notifable->id,
                notifable_type: get_class($this->notifable),
                template_id: $this->template?->id,
                text: $this->text,
                details: $this->details,
                type: $this->type,
                send_at: $this->send_at ?? now(),
                sender_id: auth()->id()
            ));

            if ($this->image) {
                Uploader::fileable($notif)
                    ->file($this->image)
                    ->dir('notification')
                    ->type('image')
                    ->upload();
            }

            $this->logService->createMany($notif->id, $this->receivers);

            DB::commit();

            event(new NewNotificationEvent($notif));

            return true;
        } catch(\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return false;
        }
    }


    public function notifable($notifable): static
    {
        $this->notifable = $notifable;
        return $this;
    }


    public function receivers(array $receivers): static
    {
        $this->receivers = $receivers;
        return $this;
    }


    public function template(string $template_name): static
    {
        $this->template = $this->templateService->findByName($template_name);

        return $this;
    }


    public function text(string $text): static
    {
        $this->text = $text;
        return $this;
    }


    public function params(array $params): static
    {
        $this->text = $this->generateText($params);
        return $this;
    }


    public function details(?array $details): static
    {
        $this->details = $details;
        return $this;
    }


    public function image($image): static
    {
        $this->image = $image;
        return $this;
    }


    public function type(string|array $type): static
    {
        $this->type = is_array($type) ? $type : [$type];
        return $this;
    }


    public function sendAt($send_at): static
    {
        $this->send_at = $send_at;
        return $this;
    }


    public function sendAfter(int $minutes): static
    {
        $this->send_at = Carbon::now()->addMinutes($minutes);
        return $this;
    }


    private function generateText($params)
    {
        $tempParams = unserialize($this->template->params);
        $text = $this->template->text;
        foreach($tempParams as $param) {
            $text = str_replace('{'.$param.'}', $params[$param] , $text);
        }

        return $text;
    }
}
