<?php

namespace Hoomat\Filesystem\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'alt' => ['required', 'string', 'max:250'],
            'file' => ['sometimes', 'nullable', 'file', 'max:2048']
        ];
    }
}
