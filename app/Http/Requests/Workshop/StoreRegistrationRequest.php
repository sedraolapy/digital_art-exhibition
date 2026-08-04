<?php

namespace App\Http\Requests\Workshop;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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
            'workshop_id' => 'required|exists:workshops,id',
        ];
    }
    public function messages(): array
    {
        return [
            'workshop_id.required' => 'يرجى اختيار الورشة.',
            'workshop_id.exists'   => 'الورشة المحددة غير موجودة.',
        ];
    }

    public function attributes(): array
    {
        return [
            'workshop_id' => 'الورشة',
        ];
    }
}
