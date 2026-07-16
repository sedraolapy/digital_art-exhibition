<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Exhibitor\SocialLinkService;
use Illuminate\Support\Facades\Storage;

class UserProfileService
{
    private SocialLinkService $socialLinkService;

    public function __construct(SocialLinkService $socialLinkService)
    {
        $this->socialLinkService = $socialLinkService;
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

        return $user->fresh(['profile']);
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
        $user->profile?->clearMediaCollection('user_profie');

        $user->profile?->addMedia($image)
            ->toMediaCollection('user_profie');
    }

    //  حذف الصورة الحالية
    private function removeProfileImage(User $user): void
    {
        if ($user->profile) {
            $user->profile->clearMediaCollection('user_profie');
        }
    }

}
