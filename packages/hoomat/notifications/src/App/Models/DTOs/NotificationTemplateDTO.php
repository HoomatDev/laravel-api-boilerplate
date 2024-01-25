<?php

namespace Hoomat\Notifications\App\Models\DTOs;

use Hoomat\Base\App\Models\BaseDTO;

class NotificationTemplateDTO extends BaseDTO
{
    public function __construct(
        public ?string $name,
        public ?string $receiver_type,
        public ?string $text,
        public null|string|array $params,
        public ?string $type
    ) {
        $this->params = serialize($this->params);
        $this->receiver_type = $this->receiver_type ?? 'customer';
    }
}
