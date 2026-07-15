<?php

namespace App\Http\Requests\ForgotPassword;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required'       => 'رمز إعادة تعيين كلمة المرور مطلوب.',

            'email.required'       => 'البريد الإلكتروني مطلوب.',
            'email.email'          => 'يرجى إدخال بريد إلكتروني صالح.',

            'password.required'    => 'كلمة المرور مطلوبة.',
            'password.confirmed'   => 'تأكيد كلمة المرور غير متطابق.',
            'password.min'         => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
            'password.regex'       => 'يجب أن تحتوي كلمة المرور على حرف كبير، وحرف صغير، ورقم، ورمز خاص.',
        ];
    }

    public function attributes(): array
    {
        return [
            'token'    => 'رمز إعادة تعيين كلمة المرور',
            'email'    => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
        ];
    }
    
}
