<?php

namespace Hoomat\Notifications\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationChangeStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'int', 'min:1', 'max:2'],
        ];
    }


    public function messages(): array
    {
        return [
            'status.*' => 'وضعیت ارسالی نامعتبر است'
        ];
    }
}
