<?php

namespace App\Http\Requests\Exhibitor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExhibitorApplicationRequest extends FormRequest
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
        $user = $this->user();

        return [
            'category_id'      => 'required|exists:categories,id',
            'experience_years' => 'required|integer|min:0',
            'cv_file'          => 'required|file|mimes:pdf,doc,docx|max:5120',
            'portfolio_url'    => 'required|url',
            'bio' => 'required|string|max:300|min:20|regex:/^[\p{Arabic}0-9٠-٩\s.,،!?؟()\-]+$/u',
            'image'        => 'required|image|max:2048',
            'instagram'        => 'required|url',
            'facebook'         => 'required|url',
            'linkedin'         => 'nullable|url',
            'behance'          => 'nullable|url',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required'      => 'يرجى اختيار المجال.',
            'category_id.exists'        => 'المجال المحدد غير صالح.',

            'experience_years.required' => 'عدد سنوات الخبرة مطلوب.',
            'experience_years.integer'  => 'يجب أن يكون عدد سنوات الخبرة رقمًا صحيحًا.',
            'experience_years.min'      => 'لا يمكن أن يكون عدد سنوات الخبرة أقل من صفر.',

            'cv_file.required'          => 'يرجى رفع السيرة الذاتية.',
            'cv_file.file'              => 'يجب أن يكون الملف المرفق صالحًا.',
            'cv_file.mimes'             => 'يجب أن تكون السيرة الذاتية بصيغة PDF أو DOC أو DOCX.',
            'cv_file.max'               => 'يجب ألا يتجاوز حجم السيرة الذاتية 5 ميغابايت.',

            'portfolio_url.required'    => 'رابط معرض الأعمال مطلوب.',
            'portfolio_url.url'         => 'يرجى إدخال رابط صالح لمعرض الأعمال.',

            'bio.required'              => 'النبذة التعريفية مطلوبة.',
            'bio.string'                => 'يجب أن تكون النبذة التعريفية نصًا.',
            'bio.max'                   => 'يجب ألا تتجاوز النبذة التعريفية 300 حرف.',
            'bio.min'                   => 'يجب ألا تقل النبذة التعريفية عن 20 حرفًا.',
            'bio.regex' => 'يجب أن تحتوي النبذة التعريفية على أحرف عربية فقط.',

            'image.required'        => 'يرجى رفع صورة شخصية.',
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
            'category_id'      => 'المجال',
            'experience_years' => 'سنوات الخبرة',
            'cv_file'          => 'السيرة الذاتية',
            'portfolio_url'    => 'رابط معرض الأعمال',
            'bio'              => 'النبذة التعريفية',
            'image'        => 'الصورة الشخصية',
            'instagram'        => 'حساب إنستغرام',
            'facebook'         => 'حساب فيسبوك',
            'linkedin'         => 'حساب لينكدإن',
            'behance'          => 'حساب Behance',
        ];
    }
}
