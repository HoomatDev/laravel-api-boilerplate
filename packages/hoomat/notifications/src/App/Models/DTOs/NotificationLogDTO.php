<?php

namespace Hoomat\Notifications\App\Models\DTOs;

use Hoomat\Base\App\Models\BaseDTO;

class NotificationLogDTO extends BaseDTO
{
    public function __construct(
        public int $notification_id,
        public int $receiver_id,
        public ?int $status,
        public mixed $created_at = null,
        public mixed $updated_at = null
    )
    {
        $this->status = $this->status ?? 1;
        $this->created_at = $this->created_at ?? now();
        $this->updated_at = $this->updated_at ?? now();
    }
}
