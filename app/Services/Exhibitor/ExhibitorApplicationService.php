<?php

namespace App\Services\Exhibitor;

use App\Enums\EventOccurrenceStatus;
use App\Enums\ExhibitorStatus;
use App\Models\ExhibitorApplication;
use App\Models\EventOccurrence;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExhibitorApplicationService
{
    private SocialLinkService $socialLinkService;

    public function __construct(SocialLinkService $socialLinkService)
    {
        $this->socialLinkService = $socialLinkService;
    }

    public function create(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $currentEvent = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->firstOrFail();

            $existing = ExhibitorApplication::where('user_id', $user->id)
                ->where('event_occurrences_id', $currentEvent->id)
                ->first();

            if ($existing) {
                throw new \Exception('You already submitted an application for this event.');
            }

            $cvPath    = $this->storeCvFile($data['cv_file']);
            $imagePath = $this->resolveImagePath($user, $data);

            $application = ExhibitorApplication::create([
                'user_id'              => $user->id,
                'event_occurrences_id' => $currentEvent->id,
                'category_id'          => $data['category_id'],
                'experience_years'     => $data['experience_years'],
                'cv_file'              => $cvPath,
                'portfolio_url'        => $data['portfolio_url'],
                'bio'                  => $data['bio'],
                'image_url'            => $imagePath,
                'status'               => ExhibitorStatus::PENDING->value,
            ]);

            $this->socialLinkService->attachLinks($application, $data);

            return $application;
        });
    }

    private function storeCvFile($cvFile): string
    {
        $filename = uniqid('app_cv_') . '.' . $cvFile->getClientOriginalExtension();
        return $cvFile->storeAs('exhibitors/applications/cv', $filename, 'public');
    }

    private function resolveImagePath(User $user, array $data): ?string
    {
        if (isset($data['image_url'])) {
            $filename = uniqid('app_img_') . '.' . $data['image_url']->getClientOriginalExtension();
            return $data['image_url']->storeAs('exhibitors/applications/images', $filename, 'public');
        }

        if ($user->profile?->profile_image_url) {
            $originalPath = $user->profile->profile_image_url;
            $fileName     = basename($originalPath);
            $newPath      = 'exhibitors/applications/images/' . $fileName;

            if (Storage::disk('public')->exists($originalPath)) {
                Storage::disk('public')->copy($originalPath, $newPath);
            }

            return $newPath;
        }
        return null;
    }

}
