<?php

namespace Hoomat\Base\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequiredRequest extends FormRequest
{
    public function rule(): array
    {
        return [
            'filters.service' => ['required', 'int', 'exists:services,id']
        ];
    }
}
