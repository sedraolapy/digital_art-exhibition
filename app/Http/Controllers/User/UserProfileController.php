<?php

namespace App\Http\Controllers\User;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Http\Resources\User\UserResource;
use App\Models\EventOccurrence;
use App\Models\Vote;
use App\Services\Lecture\BookingService;
use App\Services\Exhibitor\VoteService;
use App\Services\User\UserProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function __construct(private UserProfileService $profileService){}

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
