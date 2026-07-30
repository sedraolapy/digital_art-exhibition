<?php
namespace App\Services\Event;

use App\Enums\ExperienceStatus;
use App\Enums\RoleEnum;
use App\Models\EventOccurrence;
use App\Models\ExhibitorProfile;
use App\Models\Experience;

class EventFinishedService
{
    public function handle(EventOccurrence $event): void
    {
        $this->createExperience($event);

        $this->restoreUsersRole($event);

    }

    private function createExperience(EventOccurrence $event): void
    {
        Experience::create([
            'title'       => $event->title,
            'description' => null,
            'start_date'  => $event->start_date,
            'end_date'    => $event->end_date,
            'status'      => ExperienceStatus::DRAFT->value,
        ]);
    }

    private function restoreUsersRole(EventOccurrence $event): void
    {
        $event->exhibitors()
            ->with('user')
            ->get()
            ->each(function (ExhibitorProfile $exhibitor) {

                if (! $exhibitor->user) {
                    return;
                }

                $exhibitor->user->syncRoles([
                    RoleEnum::USER->value,
                ]);

            });
    }
}