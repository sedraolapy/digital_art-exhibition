<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassword\ForgotPasswordRequest;
use App\Http\Requests\ForgotPassword\ResetPasswordRequest;
use App\Services\ForgotPasswordService;

class ForgotPasswordController extends Controller
{
    private ForgotPasswordService $service;

    public function __construct(ForgotPasswordService $service)
    {
        $this->service = $service;
    }

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $data = $request->validated()['email'];
        $this->service->sendResetLink($data);

        return response()->json([
            'message' => 'Password reset link sent successfully, check your email.',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $this->service->resetPassword($data);

        return response()->json([
            'message' => 'Password reset successfully.',
        ]);
    }
}