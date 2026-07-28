<?php

namespace App\Http\Controllers\User;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Http\Resources\User\UserResource;
use App\Models\ExhibitorApplication;
use App\Services\Exhibitor\ExhibitorProfileService;
use App\Services\User\UserProfileService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserProfileService $userProfileService;
    private ExhibitorProfileService $exhibitorProfileService;

    public function __construct(UserProfileService $userProfileService, ExhibitorProfileService $exhibitorProfileService)
    {
        $this->userProfileService = $userProfileService;
        $this->exhibitorProfileService = $exhibitorProfileService;
    }

    public function user(Request $request)
    {
        $user = $request->user();

        $applicationStatus = ExhibitorApplication::where('user_id', $user->id )->value('status');
        $user->exhibitor_application_status = $applicationStatus;

        if ($user->hasRole(RoleEnum::EXHIBITOR->value)) {

            $profile = $this->exhibitorProfileService->getExhibitorProfileData($user);

            return response()->json([
                'message' => 'تم عرض ملف العارض بنجاح',
                'data'    => new ExhibitorProfileResource($profile),
            ]);
        }


        if ($user->hasRole(RoleEnum::USER->value)) {

            $profile = $this->userProfileService->getProfileData($user);

            return response()->json([
                'message' => 'تم عرض ملف المستخدم بنجاح',
                'data'    => new UserResource($user),
            ]);
        }

        return response()->json([
            'message' => 'لا يوجد ملف مرتبط بهذا الدور',
            'data'    => null,
        ]);
    }
}
