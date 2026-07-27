<?php
namespace App\Services\Exhibitor;

use App\Enums\Role;
use App\Models\ExhibitorApplication;
use App\Models\ExhibitorProfile;
use App\Models\User;
use App\Services\Booking\BookingService;
use Illuminate\Support\Facades\DB;
class ExhibitorProfileService
{
    private VoteService $voteService;
    private BookingService $bookingService;
    private SocialLinkService $socialLinkService;

    public function __construct(VoteService $voteService, BookingService $bookingService, SocialLinkService $socialLinkService)
    {
        $this->voteService = $voteService;
        $this->bookingService = $bookingService;
        $this->socialLinkService = $socialLinkService;
    }

    private function assignExhibitorRole(int $userId): void
    {
        User::where('id', $userId)->update([
            'role' => Role::EXHIBITOR->value,
        ]);
    }


    public function createFromApplication(ExhibitorApplication $application): ExhibitorProfile
    {
        $application->load('socialLinks');
        return DB::transaction(function () use ($application) {

            $profile = ExhibitorProfile::create([
                'user_id'               => $application->user_id,
                'event_occurrences_id'  => $application->event_occurrences_id,
                'category_id'           => $application->category_id,
                'experience_years'      => $application->experience_years,
                'portfolio_url'         => $application->portfolio_url,
                'bio'                   => $application->bio,
            ]);

            if ($application->hasMedia('application_cv')) {
                $media = $application->getFirstMedia('application_cv');

                if ($media) {
                    $profile->addMedia($media->getPath())
                        ->preservingOriginal()
                        ->toMediaCollection('exhibitor_cv');
                }
            }

            if ($application->hasMedia('application_image')) {
                $media = $application->getFirstMedia('application_image');

                if ($media) {
                    $profile->user->addMedia($media->getPath())
                        ->preservingOriginal()
                        ->toMediaCollection('exhibitor_image');
                }
            }

            $this->assignExhibitorRole($application->user_id);
            $user = $profile->user->load('socialLinks');
            $oldLinks = $application->socialLinks;

            $data = [
                'instagram' => $oldLinks->where('platform', 'instagram')->first()?->url,
                'facebook'  => $oldLinks->where('platform', 'facebook')->first()?->url,
                'linkedin'  => $oldLinks->where('platform', 'linkedin')->first()?->url,
                'behance'   => $oldLinks->where('platform', 'behance')->first()?->url,
            ];

            $this->socialLinkService->updateLinks($profile->user, $data);



            return $profile;
        });
    }


    public function getExhibitorProfileData(User $user)
    {
        $profile = $user->exhibitorProfile()->first();

        $votedExhibitors = $this->voteService->getUserVotesForActiveOccurrence($user->id);
        $bookings = $this->bookingService->getUserConfirmedBookings($user->id);

        $user->voted_exhibitors = $votedExhibitors;
        $user->bookings = $bookings;
        $user->exhibitor_application_status = ExhibitorApplication::where('user_id', $user->id)->value('status');

        $profile->user = $user;
        return $profile;
    }


    public function update(ExhibitorProfile $profile, array $data): ExhibitorProfile
    {
        if (isset($data['cv_file'])) {
            $profile->clearMediaCollection('exhibitor_cv');
            $profile->addMedia($data['cv_file'])
                ->toMediaCollection('exhibitor_cv');
        }

        if (isset($data['image'])) {
            $profile->user->clearMediaCollection('exhibitor_image');
            $profile->user->addMedia($data['image'])
                ->toMediaCollection('exhibitor_image');
        }

        $profile->update([
            'category_id'      => $data['category_id'],
            'experience_years' => $data['experience_years'],
            'portfolio_url'    => $data['portfolio_url'],
            'bio'              => $data['bio'],
        ]);

        $profile->user->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
        ]);

        $user = $profile->user;

        $votedExhibitors = $this->voteService->getUserVotesForActiveOccurrence($user->id);
        $bookings = $this->bookingService->getUserConfirmedBookings($user->id);

        $user->voted_exhibitors = $votedExhibitors;
        $user->bookings = $bookings;
        $user->exhibitor_application_status = ExhibitorApplication::where('user_id', $user->id)->value('status');

        $profile->user = $user;

        return $profile;
    }
}
