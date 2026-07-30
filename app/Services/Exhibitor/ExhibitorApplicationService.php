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
                ->where('event_occurrence_id', $currentEvent->id)
                ->first();

            if ($existing) {
                throw new \Exception('You already submitted an application for this event.');
            }


            $application = ExhibitorApplication::create([
                'user_id'              => $user->id,
                'event_occurrence_id' => $currentEvent->id,
                'category_id'          => $data['category_id'],
                'experience_years'     => $data['experience_years'],
                'portfolio_url'        => $data['portfolio_url'],
                'bio'                  => $data['bio'],
                'status'               => ExhibitorStatus::PENDING->value,
            ]);

            $this->StoreImage($application ,$data['image']);
            $this->storeCvFile($application ,$data['cv_file']);

            $this->socialLinkService->attachLinks($application, $data);

            return $application;
        });
    }

    private function storeCvFile(ExhibitorApplication $application, $cvFile): void
    {
        $application->clearMediaCollection('application_cv');

        $application->addMedia($cvFile)
            ->usingFileName(uniqid('app_cv_') . '.' . $cvFile->getClientOriginalExtension())
            ->toMediaCollection('application_cv');
    }

    private function storeImage(ExhibitorApplication $application, $image): void
    {
        $application->clearMediaCollection('application_image');

        $application->addMedia($image)
            ->usingFileName(uniqid('app_img_') . '.' . $image->getClientOriginalExtension())
            ->toMediaCollection('application_image');
    }

    public function getApplicationStatus(
        int $userId,
        int $eventOccurrenceId
    ): ?string {
        return ExhibitorApplication::where('user_id', $userId)
            ->where('event_occurrence_id', $eventOccurrenceId)
            ->value('status');
    }

}
