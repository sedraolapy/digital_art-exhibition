<?php

namespace App\Http\Requests\Event;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends FormRequest
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
            'qr_code' => ['required', 'string'],

            'lecture_id' => [
                'nullable',
                'required_without:event_day_id',
                'exists:lectures,id',
            ],

            'event_day_id' => [
                'nullable',
                'required_without:lecture_id',
                'exists:event_days,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'qr_code.required' => 'رمز QR مطلوب.',
            'qr_code.string'   => 'يجب أن يكون رمز QR نصًا صالحًا.',

            'lecture_id.required_without' => 'يجب اختيار محاضرة أو يوم فعالية.',
            'lecture_id.exists'           => 'المحاضرة المحددة غير موجودة.',

            'event_day_id.required_without' => 'يجب اختيار محاضرة أو يوم فعالية.',
            'event_day_id.exists'            => 'اليوم المحدد غير موجود.',
        ];
    }

    public function attributes(): array
    {
        return [
            'qr_code'      => 'رمز QR',
            'lecture_id'   => 'المحاضرة',
            'event_day_id' => 'اليوم',
        ];
    }
}
