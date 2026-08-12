<?php

namespace App\Services\User;

use App\Models\EventOccurrence;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\Exhibitor\SocialLinkService;

class UserProfileService
{
    public function __construct(
        private SocialLinkService $socialLinkService,
        private UserDataService $userDataService,
    ) {}

    public function getProfileData(User $user, ?EventOccurrence $activeEvent): ?UserProfile
    {
        $user = $this->userDataService->attachEventContext($user,$activeEvent);
        $profile = $user->userProfile;
 
        if(!$profile){
            return null;
        }
        
        $profile->setRelation('user',$user);

        return $profile;
    }

    public function update(UserProfile $profile, array $data): UserProfile
    {
        $this->handleProfileImage($profile, $data);
        
        $profile->user->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
        ]);

        $this->socialLinkService->updateLinks($profile, $data);

        $profile->user = $this->userDataService->attachEventContext($profile->user);

        return $profile;
    }


    private function handleProfileImage(UserProfile $profile, array $data): void
    {
        if (isset($data['image'])) {
            $this->uploadProfileImage($profile, $data['image']);
        }

        if (!empty($data['remove_image'])) {
            $this->removeProfileImage($profile);
        }
    }

    // رفع صورة جديدة
    private function uploadProfileImage(UserProfile $profile, $image): void
    {
        $profile->clearMediaCollection('user_image');

        $profile->addMedia($image)
            ->toMediaCollection('user_image');
    }

    //  حذف الصورة الحالية
    private function removeProfileImage(UserProfile $profile): void
    {
        $profile->clearMediaCollection('user_image');
    }

}
