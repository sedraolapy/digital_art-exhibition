<?php

namespace App\Services\User;

use App\Models\ExhibitorApplication;
use App\Models\User;
use App\Services\Booking\BookingService;
use App\Services\Exhibitor\SocialLinkService;
use App\Services\Exhibitor\VoteService;
use Illuminate\Support\Facades\Storage;

class UserProfileService
{
    private SocialLinkService $socialLinkService;
    private VoteService $voteService;
    private BookingService $bookingService;

    public function __construct(SocialLinkService $socialLinkService, VoteService $voteService, BookingService $bookingService)
    {
        $this->socialLinkService = $socialLinkService;
        $this->voteService = $voteService;
        $this->bookingService = $bookingService;
    }

    public function getProfileData(User $user)
    {
        $profile = $user->profile()->first();

        $votedExhibitors = $this->voteService->getUserVotesForActiveOccurrence($user->id);
        $bookings = $this->bookingService->getUserConfirmedBookings($user->id);

        $user->voted_exhibitors = $votedExhibitors;
        $user->bookings = $bookings;
        $user->exhibitor_application_status = ExhibitorApplication::where('user_id', $user->id)->value('status');

        $profile->user = $user;

        return $profile;
    }

    public function update(User $user, array $data)
    {
        $this->handleProfileImage($user, $data);

        $user->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
        ]);

        $this->socialLinkService->updateLinks($user, $data);

        $votedExhibitors = $this->voteService->getUserVotesForActiveOccurrence($user->id);
        $bookings = $this->bookingService->getUserConfirmedBookings($user->id);

        $user->voted_exhibitors = $votedExhibitors;
        $user->bookings = $bookings;
        $user->exhibitor_application_status = ExhibitorApplication::where('user_id', $user->id)->value('status');

        $profile = $user->fresh(['profile'])->profile;
        $profile->user = $user;

        return $profile;
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
