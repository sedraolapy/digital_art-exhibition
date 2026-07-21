<?php

namespace App\Http\Requests\Lecture;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'lecture_id' => 'required|exists:lectures,id',
        ];
    }

    public function messages(): array
    {
        return [
            'lecture_id.required' => 'يرجى اختيار المحاضرة.',
            'lecture_id.exists'   => 'المحاضرة المحددة غير موجودة.',
        ];
    }

    public function attributes(): array
    {
        return [
            'lecture_id' => 'المحاضرة',
        ];
    }
}
