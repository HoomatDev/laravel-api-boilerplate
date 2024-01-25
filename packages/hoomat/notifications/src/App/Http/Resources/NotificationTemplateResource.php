<?php

namespace Hoomat\Notifications\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationTemplateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            // 'text' => $this->text,
            // 'params' => unserialize($this->params),
        ];
    }
}
