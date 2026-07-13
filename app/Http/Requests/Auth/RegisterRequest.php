<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|unique:users',
            'phone'      => [
                'required',
                'string',
                'size:9',
                'regex:/^9[0-9]{8}$/',
            ],
            'password'   => 'required|string|min:8|confirmed',
            'terms'      => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'email.required'      => 'Email is required.',
            'email.unique'        => 'This email is already taken.',
            'phone.required'      => 'Phone number is required.',
            'phone.size'          => 'Phone number must be exactly 9 digits.',
            'phone.regex'         => 'Phone number must start with 9 and be 9 digits long (Syrian format).',
            'password.required'   => 'Password is required.',
            'password.confirmed'  => 'Password confirmation does not match.',
            'terms.required'      => 'You must agree to the terms and conditions.',
            'terms.accepted'      => 'You must accept the terms and conditions to proceed.',
        ];
    }
}
