<?php

namespace Hoomat\Filesystem\App\Http\Resources;

use Hoomat\Identities\App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'alt' => $this->alt,
            'type' => $this->type,
            'file' => config('app.cdn_url').'/'.$this->path,
            'created_at' => $this->created_at,

            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
