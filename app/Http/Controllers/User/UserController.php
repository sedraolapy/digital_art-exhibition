<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function user(Request $request)
    {
        $result = $this->userService->getUserProfile($request->user());

        return match ($result['type']) {

            'exhibitor' =>
                response()->json([
                    'message' => 'تم عرض ملف العارض بنجاح',
                    'data' => new ExhibitorProfileResource($result['data']),
                ]),

            'user' =>
                response()->json([
                    'message' => 'تم عرض ملف المستخدم بنجاح',
                    'data' => new UserResource($result['data']),
                ]),

            default =>
                response()->json([
                    'message' => 'لا يوجد ملف مرتبط بهذا الدور',
                    'data' => null,
                ]),
        };
    }
}