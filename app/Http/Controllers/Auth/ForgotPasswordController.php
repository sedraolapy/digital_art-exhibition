<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassword\ForgotPasswordRequest;
use App\Http\Requests\ForgotPassword\ResetPasswordRequest;
use App\Services\Auth\ForgotPasswordService;

class ForgotPasswordController extends Controller
{

    public function __construct(private ForgotPasswordService $service){}

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $data = $request->validated();
        $this->service->sendResetLink($data['email']);

        return response()->json([
            'message' => 'تم إرسال رابط إعادة تعيين كلمة المرور بنجاح، يرجى التحقق من بريدك الإلكتروني',
            'data'    => null,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $this->service->resetPassword($data);

        return response()->json([
            'message' => 'تمت إعادة تعيين كلمة المرور بنجاح',
            'data'    => null,
        ]);
    }
}