<?php

namespace Hoomat\Identities\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'min:11', 'max:11'],
            'email' => ['required', 'string', 'email'],
            'first_name' => ['required', 'string', 'min:3', 'max:30'],
            'last_name' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'boolean'],
            'avatar' => ['sometimes', 'nullable', 'mimes:jpg,png', 'max:512']
        ];
    }

    public function messages(): array
    {
        return [
            'mobile.*' => 'شماره تلفن وارد شده معتبر نیست',
            'email.*' => 'ایمیل وارد شده معتبر نیست',
            'first_name.*' => 'نام باید بین 3 تا 30 کاراکتر باشد',
            'last_name.*' => 'نام خانوادگی باید کمتر از 50 کاراکتر باشد',
            'gender.*' => 'جنسیت وارد شده معتبر نیست',
            'avatar.*' => 'آواتار باید در فرمت jpg یا png و حداکثر 512 کیلوبایت باشد',
        ];
    }
}
