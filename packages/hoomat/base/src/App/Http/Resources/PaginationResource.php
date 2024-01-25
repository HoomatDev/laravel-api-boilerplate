<?php

namespace Hoomat\Base\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'current_page' => $this->currentPage(),
            'last_page' =>  $this->lastPage(),
            'total' =>  $this->total()
        ];
    }
}
