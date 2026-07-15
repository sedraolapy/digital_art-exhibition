<?php

namespace App\Http\Requests\ForgotPassword;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email'    => 'يرجى إدخال بريد إلكتروني صالح.',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'البريد الإلكتروني',
        ];
    }
}
