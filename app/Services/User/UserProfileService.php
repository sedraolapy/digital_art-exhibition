<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserProfileService
{
    public function update(User $user, array $data): User
    {
        $this->handleProfileImage($user, $data);

        $user->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
        ]);

        return $user->fresh(['profile']);
    }

    private function handleProfileImage(User $user, array $data): void
    {
        if (isset($data['profile_image_url'])) {
            $this->uploadProfileImage($user, $data['profile_image_url']);
        }

        if (!empty($data['remove_image'])) {
            $this->removeProfileImage($user);
        }
    }

    // رفع صورة جديدة
    private function uploadProfileImage(User $user, $image): void
    {
        if ($user->profile?->profile_image_url) {
            Storage::disk('public')->delete($user->profile->profile_image_url);
        }

        $path = $image->store('profiles', 'public');
        $user->profile()->updateOrCreate([], ['profile_image_url' => $path]);
    }

    //  حذف الصورة الحالية
    private function removeProfileImage(User $user): void
    {
        if ($user->profile?->profile_image_url) {
            Storage::disk('public')->delete($user->profile->profile_image_url);
            $user->profile()->update(['profile_image_url' => null]);
        }
    }

}
