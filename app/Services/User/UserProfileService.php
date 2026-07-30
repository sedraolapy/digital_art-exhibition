<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Exhibitor\SocialLinkService;

class UserProfileService
{
    public function __construct(
        private SocialLinkService $socialLinkService,
        private UserDataService $userDataService,
    ) {}

    public function getProfileData(User $user): User
    {
        return $this->userDataService->attachEventContext($user);
    }

    public function update(User $user, array $data): User
    {
        $this->handleProfileImage($user, $data);

        $user->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
        ]);

        $this->socialLinkService->updateLinks($user, $data);

        return $this->userDataService->attachEventContext($user);
    }


    private function handleProfileImage(User $user, array $data): void
    {
        if (isset($data['image'])) {
            $this->uploadProfileImage($user, $data['image']);
        }

        if (!empty($data['remove_image'])) {
            $this->removeProfileImage($user);
        }
    }

    // رفع صورة جديدة
    private function uploadProfileImage(User $user, $image): void
    {
        $user->clearMediaCollection('user_image');

        $user->addMedia($image)
            ->toMediaCollection('user_image');
    }

    //  حذف الصورة الحالية
    private function removeProfileImage(User $user): void
    {
        $user->clearMediaCollection('user_image');
    }

}
