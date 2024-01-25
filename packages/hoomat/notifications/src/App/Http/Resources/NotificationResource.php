<?php

namespace Hoomat\Notifications\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'template' => NotificationTemplateResource::make($this->whenLoaded('template')),
            'text' => $this->text,
            'details' => $this->details,
            'type' => $this->type,
            'send_at' => $this->send_at,
            'status' => $this->status,
            'image' => $this->getFileUrl('image'),
        ];
    }
}
