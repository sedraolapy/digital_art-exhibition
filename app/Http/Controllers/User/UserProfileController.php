<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Services\User\UserProfileService;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    private UserProfileService $profileService;

    public function __construct(UserProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $profile = auth()->user()->profile()->first();
        return new UserProfileResource($profile);
    }


    public function update(UpdateUserProfileRequest $request)
    {
        $data = $request->validated();
        $user = $this->profileService->update($request->user(), $data);
        return (new UserProfileResource($user->profile))
            ->additional(['message' => 'User profile updated successfully']);
    }
}
