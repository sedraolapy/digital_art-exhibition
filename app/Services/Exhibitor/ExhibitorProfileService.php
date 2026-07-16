<?php
namespace App\Services\Exhibitor;

use App\Enums\Role;
use App\Models\ExhibitorApplication;
use App\Models\ExhibitorProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class ExhibitorProfileService
{
    private function assignExhibitorRole(int $userId): void
    {
        User::where('id', $userId)->update([
            'role' => Role::EXHIBITOR->value,
        ]);
    }

    private function transferSocialLinks(ExhibitorApplication $application, ExhibitorProfile $profile): void
    {
        if ($application->socialLinks()->exists()) {
            $socialLinks = $application->socialLinks->map(fn($link) => [
                'platform' => $link->platform,
                'url'      => $link->url,
            ])->toArray();

            $profile->socialLinks()->createMany($socialLinks);
        }
    }

    public function createFromApplication(ExhibitorApplication $application): ExhibitorProfile
    {
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
                    $profile->addMedia($media->getPath())
                        ->preservingOriginal()
                        ->toMediaCollection('exhibitor_profile');
                }
            }

            $this->assignExhibitorRole($application->user_id);
            $this->transferSocialLinks($application, $profile);

            return $profile;
        });
    }

    public function update(ExhibitorProfile $profile, array $data): ExhibitorProfile
    {
        if (isset($data['cv_file'])) {
            $profile->clearMediaCollection('exhibitor_cv');
            $profile->addMedia($data['cv_file'])
                ->toMediaCollection('exhibitor_cv');
        }

        if (isset($data['image'])) {
            $profile->clearMediaCollection('exhibitor_profile');
            $profile->addMedia($data['image'])
                ->toMediaCollection('exhibitor_profile');
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

        return $profile;
    }
}
