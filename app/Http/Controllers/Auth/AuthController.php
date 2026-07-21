<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $data= $request->validated();
        $result = $this->authService->register($data);

        $result['user']->token = $result['token'];

        return response()->json([
            'message' => 'تم تسجيل المستخدم بنجاح',
            'data'    => new UserResource($result['user']),
        ]);
    }

    public function login(LoginRequest $request)
    {
        $data= $request->validated();
        $result = $this->authService->login($data);

        $result['user']->token = $result['token'];
        $result['user']->voted_exhibitors = $result['voted_exhibitors'];

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'data'    => new UserResource($result['user']),
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
