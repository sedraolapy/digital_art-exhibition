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
                'required_without_all:event_day_id,workshop_id',
                'prohibited_unless:event_day_id,null,workshop_id,null',
                'exists:lectures,id',
            ],

            'event_day_id' => [
                'nullable',
                'required_without_all:lecture_id,workshop_id',
                'prohibited_unless:lecture_id,null,workshop_id,null',
                'exists:event_days,id',
            ],

            'workshop_id' => [
                'nullable',
                'required_without_all:lecture_id,event_day_id',
                'prohibited_unless:lecture_id,null,event_day_id,null',
                'exists:workshops,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'qr_code.required' => 'رمز QR مطلوب.',
            'qr_code.string' => 'رمز QR غير صالح.',

            'lecture_id.required_without_all' => 'يجب اختيار محاضرة أو يوم فعالية أو ورشة عمل.',
            'lecture_id.prohibited_unless' => 'لا يمكن اختيار محاضرة مع يوم فعالية أو ورشة عمل.',
            'lecture_id.exists' => 'المحاضرة المحددة غير موجودة.',

            'event_day_id.required_without_all' => 'يجب اختيار محاضرة أو يوم فعالية أو ورشة عمل.',
            'event_day_id.prohibited_unless' => 'لا يمكن اختيار يوم فعالية مع محاضرة أو ورشة عمل.',
            'event_day_id.exists' => 'يوم الفعالية المحدد غير موجود.',

            'workshop_id.required_without_all' => 'يجب اختيار محاضرة أو يوم فعالية أو ورشة عمل.',
            'workshop_id.prohibited_unless' => 'لا يمكن اختيار ورشة عمل مع محاضرة أو يوم فعالية.',
            'workshop_id.exists' => 'ورشة العمل المحددة غير موجودة.',
        ];
    }

    public function attributes(): array
    {
        return [
            'qr_code' => 'رمز QR',
            'lecture_id' => 'المحاضرة',
            'event_day_id' => 'يوم الفعالية',
            'workshop_id' => 'ورشة العمل',
        ];
    }
    
}
