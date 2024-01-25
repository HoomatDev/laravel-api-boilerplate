<?php

namespace Hoomat\Notifications\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            // 'receiver' => UserCompactResource::make($this->whenLoaded('receiver'))->setWithMobile(true),
            'status' => $this->status
        ];
    }
}
