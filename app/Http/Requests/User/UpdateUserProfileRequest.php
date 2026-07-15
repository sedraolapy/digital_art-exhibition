<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'first_name' => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'last_name'  => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'phone'      => [
                'required',
                'string',
                'size:9',
                'regex:/^9[0-9]{8}$/',
            ],
            'profile_image_url' => 'nullable|image|max:2048',
            'remove_image' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'      => 'الاسم الأول مطلوب.',
            'first_name.string'        => 'يجب أن يكون الاسم الأول نصًا.',
            'first_name.max'           => 'يجب ألا يزيد الاسم الأول عن 255 حرفًا.',
            'first_name.regex' => 'يجب أن يحتوي الاسم الأول على أحرف عربية فقط.',

            'last_name.required'       => 'اسم العائلة مطلوب.',
            'last_name.string'         => 'يجب أن يكون اسم العائلة نصًا.',
            'last_name.max'            => 'يجب ألا يزيد اسم العائلة عن 255 حرفًا.',
            'last_name.regex'  => 'يجب أن يحتوي اسم العائلة على أحرف عربية فقط.',

            'phone.required'           => 'رقم الهاتف مطلوب.',
            'phone.string'             => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.size'               => 'يجب أن يتكون رقم الهاتف من 9 أرقام.',
            'phone.regex'              => 'يجب أن يبدأ رقم الهاتف بالرقم 9 وأن يتكون من 9 أرقام (وفقًا للصيغة السورية).',

            'profile_image_url.image'  => 'يجب أن يكون الملف المرفق صورة.',
            'profile_image_url.max'    => 'يجب ألا يتجاوز حجم الصورة 2 ميغابايت.',

            'remove_image.boolean'     => 'قيمة إزالة الصورة غير صحيحة.',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name'       => 'الاسم الأول',
            'last_name'        => 'اسم العائلة',
            'phone'            => 'رقم الهاتف',
            'profile_image_url'=> 'الصورة الشخصية',
            'remove_image'     => 'إزالة الصورة',
        ];
    }

}
