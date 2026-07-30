<?php

namespace App\Services\Exhibitor;

use App\Enums\ExhibitorStatus;
use App\Models\ExhibitorApplication;
use App\Models\User;
use App\Services\Event\EventService;
use Illuminate\Support\Facades\DB;

class ExhibitorApplicationService
{
    public function __construct(
        private SocialLinkService $socialLinkService,
        private EventService $eventService,
    ) {}

    public function create(User $user, array $data): ExhibitorApplication
    {
        return DB::transaction(function () use ($user, $data) {
            $currentEvent = $this->eventService->getActiveEvent();

            if (! $currentEvent) {
                throw new \Exception('لا يوجد حدث فعّال حالياً لتقديم طلب عرض.');
            }

            if ($this->applicationExists($user->id, $currentEvent->id)) {
                throw new \Exception('لقد قمت بتقديم طلب لهذه الفعالية مسبقًا.');
            }

            $application = ExhibitorApplication::create([
                'user_id'             => $user->id,
                'event_occurrence_id' => $currentEvent->id,
                'category_id'         => $data['category_id'],
                'experience_years'    => $data['experience_years'],
                'portfolio_url'       => $data['portfolio_url'],
                'bio'                 => $data['bio'],
                'status'              => ExhibitorStatus::PENDING->value,
            ]);

            $this->storeImage($application, $data['image']);
            $this->storeCvFile($application, $data['cv_file']);
            $this->socialLinkService->attachLinks($application, $data);

            return $application;
        });
    }

    public function getApplicationStatus(int $userId, int $eventOccurrenceId)
    {
        $applicationStatus =  ExhibitorApplication::where('user_id', $userId)
            ->where('event_occurrence_id', $eventOccurrenceId)
            ->value('status');
        return $applicationStatus;
    }

    private function applicationExists(int $userId, int $eventOccurrenceId): bool
    {
        return ExhibitorApplication::where('user_id', $userId)
            ->where('event_occurrence_id', $eventOccurrenceId)
            ->exists();
    }

    private function storeCvFile(ExhibitorApplication $application, $cvFile): void
    {
        $application->clearMediaCollection('application_cv');
        $application->addMedia($cvFile)->toMediaCollection('application_cv');
    }

    private function storeImage(ExhibitorApplication $application, $image): void
    {
        $application->clearMediaCollection('application_image');
        $application->addMedia($image)->toMediaCollection('application_image');
    }
}
