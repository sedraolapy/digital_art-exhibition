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
            'first_name' => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'last_name'  => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'email'      => 'required|string|email|unique:users',
            'phone'      => [
                'required',
                'string',
                'max:20',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'terms'      => 'required|accepted',
            'instagram' => ['nullable', 'url', 'required_without:facebook'],
            'facebook'  => ['nullable', 'url', 'required_without:instagram'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'الاسم الأول مطلوب.',
            'last_name.required'  => 'اسم العائلة مطلوب.',
            'first_name.regex' => 'يجب أن يحتوي الاسم الأول على أحرف عربية فقط.',
            'last_name.regex'  => 'يجب أن يحتوي اسم العائلة على أحرف عربية فقط.',

            'email.required'      => 'البريد الإلكتروني مطلوب.',
            'email.unique'        => 'هذا البريد الإلكتروني مستخدم بالفعل.',

            'phone.required'      => 'رقم الهاتف مطلوب.',
            'phone.size'          => 'يجب أن يتكون رقم الهاتف من 9 أرقام.',
            'phone.regex'         => 'يجب أن يبدأ رقم الهاتف بالرقم 9 وأن يتكون من 9 أرقام (وفقًا للصيغة السورية).',

            'password.required'   => 'كلمة المرور مطلوبة.',
            'password.confirmed'  => 'تأكيد كلمة المرور غير متطابق.',
            'password.min'        => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
            'password.regex'      => 'يجب أن تحتوي كلمة المرور على حرف كبير، وحرف صغير، ورقم، ورمز خاص.',

            'instagram.required_without' => 'يجب إدخال رابط إنستغرام إذا لم يتم إدخال رابط فيسبوك.',
            'instagram.url'              => 'رابط إنستغرام يجب أن يكون رابط صحيح.',

            'facebook.required_without'  => 'يجب إدخال رابط فيسبوك إذا لم يتم إدخال رابط إنستغرام.',
            'facebook.url'               => 'رابط فيسبوك يجب أن يكون رابط صحيح.',

            'terms.required'      => 'يجب الموافقة على الشروط والأحكام.',
            'terms.accepted'      => 'يجب قبول الشروط والأحكام للمتابعة.',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'الاسم الأول',
            'last_name'  => 'اسم العائلة',
            'email'      => 'البريد الإلكتروني',
            'phone'      => 'رقم الهاتف',
            'password'   => 'كلمة المرور',
            'instagram'        => 'حساب إنستغرام',
            'facebook'         => 'حساب فيسبوك',
            'terms'      => 'الشروط والأحكام',
        ];
    }
}
