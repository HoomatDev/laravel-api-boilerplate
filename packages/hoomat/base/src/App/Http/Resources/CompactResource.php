<?php

namespace Hoomat\Base\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompactResource extends JsonResource
{
    private string $field = 'name';
    private ?string $customName = null;


    public function setField(string $field, $customName = null): static
    {
        $this->field = $field;
        $this->customName = $customName;
        return $this;
    }


    public function toArray(Request $request): array
    {
        $field = $this->field;
        $customName = $this->customName;
        return [
            'id' => $this->id,
            $customName ?: $field => $this->$field,
        ];
    }
}
