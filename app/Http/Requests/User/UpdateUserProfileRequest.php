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
            'phone' => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-\(\)]+$/',
                'max:20',
            ],
            'instagram' => ['nullable', 'url', 'required_without:facebook'],
            'facebook'  => ['nullable', 'url', 'required_without:instagram'],
            'image' => 'nullable|image|max:2048',
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

            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string' => 'رقم الهاتف يجب أن يكون نصًا صالحًا.',
            'phone.regex' => 'رقم الهاتف يجب أن يحتوي على أرقام فقط، ويمكن أن يتضمن + أو المسافات أو الشرطات أو الأقواس.',
            'phone.max' => 'رقم الهاتف يجب ألا يتجاوز 20 محرفًا.',
            
            'instagram.required_without' => 'يجب إدخال رابط إنستغرام إذا لم يتم إدخال رابط فيسبوك.',
            'instagram.url'              => 'رابط إنستغرام يجب أن يكون رابط صحيح.',

            'facebook.required_without'  => 'يجب إدخال رابط فيسبوك إذا لم يتم إدخال رابط إنستغرام.',
            'facebook.url'               => 'رابط فيسبوك يجب أن يكون رابط صحيح.',

            'image.image'  => 'يجب أن يكون الملف المرفق صورة.',
            'image.max'    => 'يجب ألا يتجاوز حجم الصورة 2 ميغابايت.',

            'remove_image.boolean'     => 'قيمة إزالة الصورة غير صحيحة.',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name'       => 'الاسم الأول',
            'last_name'        => 'اسم العائلة',
            'phone'            => 'رقم الهاتف',
            'instagram'        => 'حساب إنستغرام',
            'facebook'         => 'حساب فيسبوك',
            'image'            => 'الصورة الشخصية',
            'remove_image'     => 'إزالة الصورة',
        ];
    }

}
