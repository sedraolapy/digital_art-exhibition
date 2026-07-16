<?php

namespace App\Http\Requests\Exhibitor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExhibitorProfileRequest extends FormRequest
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
            'category_id'      => 'required|exists:categories,id',
            'experience_years' => 'required|integer|min:0',
            'cv_file'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'portfolio_url'    => 'required|url',
            'bio'              => 'required|string|max:300|min:20|regex:/^[\p{Arabic}\s.,،!?؟()\-]+$/u',
            'image'        => 'nullable|image|max:2048',
            'instagram'        => 'required|url',
            'facebook'         => 'required|url',
            'linkedin'         => 'nullable|url',
            'behance'          => 'nullable|url',
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

            'category_id.required'      => 'يرجى اختيار المجال.',
            'category_id.exists'        => 'المجال المحدد غير صالح.',

            'experience_years.required' => 'عدد سنوات الخبرة مطلوب.',
            'experience_years.integer'  => 'يجب أن يكون عدد سنوات الخبرة رقمًا صحيحًا.',
            'experience_years.min'      => 'لا يمكن أن يكون عدد سنوات الخبرة أقل من صفر.',

            'cv_file.file'              => 'يجب أن يكون الملف المرفق صالحًا.',
            'cv_file.mimes'             => 'يجب أن تكون السيرة الذاتية بصيغة PDF أو DOC أو DOCX.',
            'cv_file.max'               => 'يجب ألا يتجاوز حجم السيرة الذاتية 5 ميغابايت.',

            'portfolio_url.required'    => 'رابط معرض الأعمال مطلوب.',
            'portfolio_url.url'         => 'يرجى إدخال رابط صالح لمعرض الأعمال.',

            'bio.required'              => 'النبذة التعريفية مطلوبة.',
            'bio.string'                => 'يجب أن تكون النبذة التعريفية نصًا.',
            'bio.min'                   => 'يجب ألا تقل النبذة التعريفية عن 20 حرفًا.',
            'bio.max'                   => 'يجب ألا تتجاوز النبذة التعريفية 300 حرف.',
            'bio.regex'                 => 'يجب أن تحتوي النبذة التعريفية على أحرف عربية فقط.',

            'image.image'           => 'يجب أن يكون الملف المرفق صورة.',
            'image.max'             => 'يجب ألا يتجاوز حجم الصورة 2 ميغابايت.',

            'instagram.required'        => 'رابط حساب إنستغرام مطلوب.',
            'instagram.url'             => 'يرجى إدخال رابط صالح لحساب إنستغرام.',

            'facebook.required'         => 'رابط حساب فيسبوك مطلوب.',
            'facebook.url'              => 'يرجى إدخال رابط صالح لحساب فيسبوك.',

            'linkedin.url'              => 'يرجى إدخال رابط صالح لحساب لينكدإن.',

            'behance.url'               => 'يرجى إدخال رابط صالح لحساب Behance.',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name'       => 'الاسم الأول',
            'last_name'        => 'اسم العائلة',
            'phone'            => 'رقم الهاتف',
            'category_id'      => 'المجال',
            'experience_years' => 'سنوات الخبرة',
            'cv_file'          => 'السيرة الذاتية',
            'portfolio_url'    => 'رابط معرض الأعمال',
            'bio'              => 'النبذة التعريفية',
            'image_url'        => 'الصورة الشخصية',
            'instagram'        => 'حساب إنستغرام',
            'facebook'         => 'حساب فيسبوك',
            'linkedin'         => 'حساب لينكدإن',
            'behance'          => 'حساب Behance',
        ];
    }

}
