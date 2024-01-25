<?php

namespace Hoomat\Notifications\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationWebpushInitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'endpoint' => ['required', 'string'],
            'keys.auth' => ['sometimes', 'nullable', 'string'],
            'keys.p256dh' => ['sometimes', 'nullable', 'string']
        ];
    }


    public function messages(): array
    {
        return [
            'endpoint.*' => 'آدرس دریافت کننده ارسالی نامعتبر است'
        ];
    }
}
