<?php

namespace App\Http\Requests\Exhibitor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VoteRequest extends FormRequest
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
            'exhibitor_id'  => ['required', 'exists:exhibitor_profiles,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'exhibitor_id.required'        => 'يرجى اختيار العارض.',
            'exhibitor_id.exists'          => 'العارض المحدد غير موجود.',
        ];
    }

    public function attributes(): array
    {
        return [
            'exhibitor_id'        => 'العارض',
        ];
    }
}
