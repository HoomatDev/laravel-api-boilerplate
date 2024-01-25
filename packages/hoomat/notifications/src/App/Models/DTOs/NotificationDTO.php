<?php

namespace Hoomat\Notifications\App\Models\DTOs;

use Hoomat\Base\App\Models\BaseDTO;

class NotificationDTO extends BaseDTO
{
    public function __construct(
        public int $notifable_id,
        public string $notifable_type,
        public ?int $template_id,
        public ?string $text,
        public ?array $details,
        public array|string|null $type,
        public mixed $send_at,
        public ?int $sender_id = null
    )
    {
        if (!$this->type || !is_array($this->type)) {
            $this->type = $this->type ? [$this->type] : ['sms'];
        }
        $this->send_at = $this->send_at ?? now();
    }
}
