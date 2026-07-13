<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
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

        return response()->json([
            'message' => 'User registered successfully',
            'token'   => $result['token'],
            'user'    => new UserResource($result['user']),
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data= $request->validated();
        $result = $this->authService->login($data);

        return response()->json([
            'message' => 'Login successful',
            'token'   => $result['token'],
            'user'    => new UserResource($result['user']),
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
