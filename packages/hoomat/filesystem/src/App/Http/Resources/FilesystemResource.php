<?php

namespace Hoomat\Filesystem\App\Http\Resources;

use Hoomat\Identities\App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FilesystemResource extends JsonResource
{
    public function toArray($request): array
    {
        $exists = Storage::disk($this->disk)->exists($this->path);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'alt' => $this->alt,
            'type' => $this->type,
            'file' => config('app.cdn_url').'/'.$this->path,
            'created_at' => $this->created_at,
            'size' => $exists ? Storage::disk($this->disk)->size($this->path) : null,

            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
