<?php

namespace App\Services\Exhibitor;

use App\Enums\Role;
use App\Models\ExhibitorApplication;
use App\Models\ExhibitorProfile;
use App\Models\User;
use Storage;

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
        $profile = ExhibitorProfile::create([
            'user_id'              => $application->user_id,
            'event_occurrences_id' => $application->event_occurrences_id,
            'category_id'          => $application->category_id,
            'experience_years'     => $application->experience_years,
            'cv_file'              => $this->copyApplicationFile($application->cv_file, 'exhibitors/profiles/cv'),
            'portfolio_url'        => $application->portfolio_url,
            'bio'                  => $application->bio,
            'image_url'            => $this->copyApplicationFile($application->image_url, 'exhibitors/profiles/images'),
        ]);

        $this->assignExhibitorRole($application->user_id);

        $this->transferSocialLinks($application, $profile);

        return $profile;
    }

    private function copyApplicationFile(?string $originalPath, string $targetFolder): ?string
    {
        if (! $originalPath || ! Storage::disk('public')->exists($originalPath)) {
            return null;
        }

        $newPath = $targetFolder . '/' . basename($originalPath);
        Storage::disk('public')->copy($originalPath, $newPath);

        return $newPath;
    }

    private function storeCvFile(ExhibitorProfile $profile, $cvFile): string
    {
        if ($profile->cv_file) {
            Storage::disk('public')->delete($profile->cv_file);
        }

        $filename = uniqid('cv_') . '.' . $cvFile->getClientOriginalExtension();
        return $cvFile->storeAs('exhibitors/profiles/cv', $filename, 'public');
    }

    private function storeProfileImage(ExhibitorProfile $profile, $imageFile): string
    {
        if ($profile->image_url) {
            Storage::disk('public')->delete($profile->image_url);
        }

        $filename = uniqid('img_') . '.' . $imageFile->getClientOriginalExtension();
        return $imageFile->storeAs('exhibitors/profiles/images', $filename, 'public');
    }


    public function update(ExhibitorProfile $profile, array $data): ExhibitorProfile
    {
        if (isset($data['image_url'])) {
            $data['image_url'] = $this->storeProfileImage($profile, $data['image_url']);
        }

        if (isset($data['cv_file'])) {
            $data['cv_file'] = $this->storeCvFile($profile, $data['cv_file']);
        }

        $profile->update([
            'category_id'      => $data['category_id'],
            'experience_years' => $data['experience_years'],
            'portfolio_url'    => $data['portfolio_url'],
            'bio'              => $data['bio'],
            'cv_file'          => $data['cv_file'] ?? $profile->cv_file,
            'image_url'        => $data['image_url'] ?? $profile->image_url,
        ]);

        $profile->user->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
        ]);

        return $profile;
    }


}

