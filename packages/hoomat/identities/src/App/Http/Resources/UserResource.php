<?php

namespace Hoomat\Identities\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'national_code' => $this->national_code,
            'gender' => $this->gender,
            'avatar' => $this->getFileUrl('avatar'),
        ];
    }
}
