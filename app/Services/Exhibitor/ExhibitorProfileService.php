<?php

namespace App\Services\Exhibitor;

use App\Enums\EventOccurrenceStatus;
use App\Enums\RoleEnum;
use App\Models\EventOccurrence;
use App\Models\ExhibitorApplication;
use App\Models\ExhibitorProfile;
use App\Models\User;
use App\Services\Event\EventService;
use App\Services\User\UserDataService;
use Illuminate\Support\Facades\DB;

class ExhibitorProfileService
{
    public function __construct(
        private SocialLinkService $socialLinkService,
        private UserDataService $userDataService,
        private EventService $eventService,
    ) {}

    private function assignExhibitorRole(int $userId): void
    {
        User::findOrFail($userId)->syncRoles(RoleEnum::EXHIBITOR->value);
    }

    public function createFromApplication(ExhibitorApplication $application): ExhibitorProfile
    {
        $application->load('socialLinks');

        return DB::transaction(function () use ($application) {
            $profile = ExhibitorProfile::create([
                'user_id'             => $application->user_id,
                'event_occurrence_id' => $application->event_occurrence_id,
                'category_id'         => $application->category_id,
                'experience_years'    => $application->experience_years,
                'portfolio_url'       => $application->portfolio_url,
                'bio'                 => $application->bio,
            ]);

            $this->transferCvFile($application, $profile);
            $this->transferImage($application, $profile);
            $this->assignExhibitorRole($application->user_id);
            $this->updateSocialLinksFromApplication($application, $profile->user);

            return $profile;
        });
    }

    public function getExhibitorProfileData(User $user): ?ExhibitorProfile
    {
        $activeEvent = $this->eventService->getActiveEvent();

        if (! $activeEvent) {
            return null;
        }

        $profile = $user->exhibitorProfiles()
            ->where('event_occurrence_id', $activeEvent->id)
            ->first();

        if (! $profile) {
            return null;
        }

        $profile->user = $this->userDataService->attachEventContext($user);

        return $profile;
    }

    public function update(ExhibitorProfile $profile, array $data): ExhibitorProfile
    {
        $this->updateCvFile($profile, $data);
        $this->updateImage($profile, $data);

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

        $profile->user = $this->userDataService->attachEventContext($profile->user);

        return $profile;
    }


    private function transferCvFile(ExhibitorApplication $application, ExhibitorProfile $profile): void
    {
        if ($application->hasMedia('application_cv')) {
            $media = $application->getFirstMedia('application_cv');
            if ($media) {
                $profile->addMedia($media->getPath())
                    ->preservingOriginal()
                    ->toMediaCollection('exhibitor_cv');
            }
        }
    }

    private function transferImage(ExhibitorApplication $application, ExhibitorProfile $profile): void
    {
        if ($application->hasMedia('application_image')) {
            $media = $application->getFirstMedia('application_image');
            if ($media) {
                $profile->user->addMedia($media->getPath())
                    ->preservingOriginal()
                    ->toMediaCollection('exhibitor_image');
            }
        }
    }

    private function updateSocialLinksFromApplication(ExhibitorApplication $application, User $user): void
    {
        $oldLinks = $application->socialLinks;

        $data = collect(SocialLinkService::PLATFORMS)
            ->mapWithKeys(fn ($platform) => [
                $platform => $oldLinks->where('platform', $platform)->first()?->url,
            ])
            ->toArray();

        $this->socialLinkService->updateLinks($user, $data);
    }

    private function updateCvFile(ExhibitorProfile $profile, array $data): void
    {
        if (isset($data['cv_file'])) {
            $profile->clearMediaCollection('exhibitor_cv');
            $profile->addMedia($data['cv_file'])->toMediaCollection('exhibitor_cv');
        }
    }

    private function updateImage(ExhibitorProfile $profile, array $data): void
    {
        if (isset($data['image'])) {
            $profile->user->clearMediaCollection('exhibitor_image');
            $profile->user->addMedia($data['image'])->toMediaCollection('exhibitor_image');
        }
    }
}
