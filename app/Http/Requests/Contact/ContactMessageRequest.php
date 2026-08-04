<?php

namespace App\Http\Requests\Contact;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:5000',
            'captcha_token' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'الاسم مطلوب.',
            'name.string'      => 'يجب أن يكون الاسم نصًا.',
            'name.max'         => 'يجب ألا يزيد الاسم عن 255 حرفًا.',

            'email.required'   => 'البريد الإلكتروني مطلوب.',
            'email.email'      => 'يرجى إدخال بريد إلكتروني صالح.',
            'email.max'        => 'يجب ألا يزيد البريد الإلكتروني عن 255 حرفًا.',

            'phone.required'   => 'رقم الهاتف مطلوب.',
            'phone.string'     => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.max'        => 'يجب ألا يزيد رقم الهاتف عن 20 محرفًا.',

            'message.required' => 'الرسالة مطلوبة.',
            'message.string'   => 'يجب أن تكون الرسالة نصًا.',
            'message.max'      => 'يجب ألا تتجاوز الرسالة 5000 حرف.',


            'captcha_token.required' => 'يرجى إكمال التحقق الأمني.',
            'captcha_token.string' => 'رمز التحقق الأمني غير صالح.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'    => 'الاسم',
            'email'   => 'البريد الإلكتروني',
            'phone'   => 'رقم الهاتف',
            'message' => 'الرسالة',
            'captcha_token' => 'رمز التحقق الأمني',
        ];
    }

}
