<?php

namespace Hoomat\Notifications\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => ['sometimes', 'nullable', 'int', 'min:5'],
            'filters.template' => ['sometimes', 'nullable', 'int', 'exists:notification_templates,id'],
            'filters.sent' => ['sometimes', 'nullable', 'boolean'],
            'filters.type' => ['sometimes', 'nullable', 'string', 'in:sms,email,webpush,in-app'],
            'filters.created_at.*' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'filters.order_by' => ['sometimes', 'nullable', 'string', 'in:created_at,send_at'],
            'filters.order_dir' => ['sometimes', 'nullable', 'string', 'in:asc,desc'],
            'filters.search' => ['sometimes', 'nullable', 'string']
        ];
    }


    public function messages(): array
    {
        return [
            'limit.*' => 'وضعیت ارسالی نامعتبر است',
            'filters.template.*' => 'فیلتر رویداد انتخاب شده نامعتبر است',
            'filters.sent.*' => 'مقدار فیلتر وضعیت ارسال نامعتبر است',
            'filters.type.*' => 'مقدار فیلتر نوع نامعتبر است',
            'filters.created_at.*' => 'مقدار فیلتر زمان ارسال نامعتبر است',
            'filters.order_by.*' => 'ستون انتخاب شده برای مرتب سازی نامعتبر است',
            'filters.order_dir.*' => 'ترتیب انتخاب شده برای مرتب سازی نامعتبر است',
        ];
    }
}
