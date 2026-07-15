<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'البريد الإلكتروني مطلوب.',
            'email.string'      => 'يجب أن يكون البريد الإلكتروني نصاً.',
            'email.email'       => 'يرجى إدخال بريد إلكتروني صالح.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string'   => 'يجب أن تكون كلمة المرور نصاً.',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
        ];
    }
}
