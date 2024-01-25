<?php

namespace Hoomat\Notifications\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => ['required', 'string'],
            'details' => ['required', 'array'],
            'type' => ['required', 'string', 'in:sms,email,webpush'],
            'send_at' => ['sometimes', 'nullable', 'date'],
            'image' => [
                'sometimes',
                'nullable',
                'mimes:jpeg,png,jpg',
                'max:1024'
            ]
        ];
    }


    public function messages(): array
    {
        return [
            'text.*' => 'متن پیام نوتیفیکیشن اجباری است',
            'details.*' => 'جزئیات وارد شده نامعتبر است',
            'type.*' => 'نوع انتخاب شده نامعتبر است',
            'send_at.*' => 'زمان ارسال وارد شده نامعتبر است',
            'image.*' => 'تصویر انتخاب شده نامعتبر است',
        ];
    }
}
