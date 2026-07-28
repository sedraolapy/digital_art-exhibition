<?php

namespace App\Http\Controllers\User;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Http\Resources\User\UserResource;
use App\Models\EventOccurrence;
use App\Models\Vote;
use App\Services\Booking\BookingService;
use App\Services\Exhibitor\VoteService;
use App\Services\User\UserProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    private UserProfileService $profileService;

    public function __construct(UserProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $user = Auth::user();

        $user = $this->profileService->getProfileData($user);

        return response()->json([
            'message' => 'تم عرض ملف المستخدم بنجاح',
            'data'    => new UserResource($user),
        ]);
    }


    public function update(UpdateUserProfileRequest $request)
    {
        $data = $request->validated();
        $user =$request->user();

        $user = $this->profileService->update($user, $data);

        return response()->json([
            'message' => 'تم تحديث ملف المستخدم بنجاح',
            'data'    => new UserResource($user),
        ]);
    }

}
