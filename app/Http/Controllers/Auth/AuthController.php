<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserResource;
use App\Models\ExhibitorApplication;
use App\Services\Auth\AuthService;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService, private UserService $userService){}

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        $user = $result['user'];
        $user->token = $result['token'];
        $user->userProfile->user->token = $result['token'];

        return response()->json([
            'message' => 'تم تسجيل المستخدم بنجاح',
            'data'    => new UserProfileResource($user->userProfile),
        ]);
    }

    public function login(LoginRequest $request)
{
    $result = $this->authService->login($request->validated());

    $user = $result['user'];

    $user->token = $result['token'];

    $profileResult = $this->userService->getUserProfile($user);

    $profileResource = match ($profileResult['type']) {

        'exhibitor' =>
            new ExhibitorProfileResource(
                $profileResult['data']
            ),

        'user' =>
            new UserProfileResource(
                $profileResult['data']
            ),

        default =>
            new UserResource($user),
    };

    return response()->json([
        'message' => 'تم تسجيل الدخول بنجاح',
        'data' => $profileResource,
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
