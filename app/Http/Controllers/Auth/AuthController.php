<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\ExhibitorApplication;
use App\Services\Auth\AuthService;
use App\Services\CheckIn\UserAttendanceService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService){}

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        $user = $result['user'];
        $user->token = $result['token'];

        return response()->json([
            'message' => 'تم تسجيل المستخدم بنجاح',
            'data'    => new UserResource($user),
        ]);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        $user = $result['user'];
        $user->token = $result['token'];

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'data'    => new UserResource($user),
        ]);
    }


    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
            'data'    => null,
        ]);
    }
}
