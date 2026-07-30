<?php

namespace App\Services\User;

use App\Enums\RoleEnum;
use App\Services\CheckIn\UserAttendanceService;
use App\Services\Exhibitor\ExhibitorProfileService;

class UserService
{
    public function __construct(
        private UserAttendanceService $attendanceService,
        private ExhibitorProfileService $exhibitorProfileService,
        private UserProfileService $userProfileService
    ) {}



    public function getUserProfile($user): array
    {
        $user->is_checked_in = $this->attendanceService->hasCheckedIn($user);


        if ($user->hasRole(RoleEnum::EXHIBITOR->value)) {

            return [
                'type' => 'exhibitor',
                'data' => $this->exhibitorProfileService->getExhibitorProfileData($user),
            ];
        }


        if ($user->hasRole(RoleEnum::USER->value)) {

            return [
                'type' => 'user',
                'data' => $this->userProfileService->getProfileData($user),
            ];
        }


        return [
            'type' => null,
            'data' => null,
        ];
    }
}