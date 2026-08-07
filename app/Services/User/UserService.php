<?php

namespace App\Services\User;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\CheckIn\CheckInService;
use App\Services\Event\EventService;
use App\Services\Exhibitor\ExhibitorProfileService;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private ExhibitorProfileService $exhibitorProfileService,
        private UserProfileService $userProfileService,
        private CheckInService $checkInService,
        private EventService $eventService,
    ) {}

    public function createUser(array $data): User
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => Hash::make($data['password']),
        ]);
    }


    public function getUserProfile(User $user): array
    {
        $activeEvent = $this->eventService->getActiveEvent();

        $user->is_checked_in = $activeEvent
            ? $this->checkInService->hasCheckedIn($user, $activeEvent)
            : false;

        if ($user->hasRole(RoleEnum::EXHIBITOR->value)) {
            return [
                'type' => 'exhibitor',
                'data' => $this->exhibitorProfileService
                    ->getExhibitorProfileData($user, $activeEvent),
            ];
        }

        if ($user->hasRole(RoleEnum::USER->value)) {
            return [
                'type' => 'user',
                'data' => $this->userProfileService
                    ->getProfileData($user, $activeEvent),
            ];
        }

        return [
            'type' => null,
            'data' => null,
        ];
    }

}
