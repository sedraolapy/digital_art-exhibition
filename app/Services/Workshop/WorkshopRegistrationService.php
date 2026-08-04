<?php

namespace App\Services\Workshop;

use App\Enums\BookingStatus;
use App\Enums\WorkshopStatus;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Illuminate\Support\Facades\DB;

class WorkshopRegistrationService
{
    public function createRegistration(int $userId, int $workshopId)
    {
        return DB::transaction(function () use ($userId, $workshopId) {
            $workshop = $this->lockWorkshop($workshopId);

            $this->checkDuplicateRegistration($userId, $workshopId);
            $this->checkWorkshopNotEnded($workshop);
            $this->checkSeatsAvailability($workshop);

            return WorkshopRegistration::create([
                'user_id'    => $userId,
                'workshop_id' => $workshopId,
                'status'     => BookingStatus::CONFIRMED->value,
            ]);
        });
    }

    private function lockWorkshop(int $workshopId)
    {
        return Workshop::whereKey($workshopId)->lockForUpdate()->firstOrFail();
    }

    private function checkDuplicateRegistration(int $userId, int $workshopId): void
    {
        if (WorkshopRegistration::where('user_id', $userId)->where('workshop_id', $workshopId)->exists()) {
            throw new \Exception('لقد قمت بحجز هذه الورشة مسبقاً');
        }
    }

    private function checkWorkshopNotEnded(Workshop $workshop): void
    {
        if ($workshop->status == WorkshopStatus::FINISHED->value) {
            throw new \Exception('انتهى وقت التسجيل لهذه الورشة');
        }
    }

    private function checkSeatsAvailability(Workshop $workshop): void
    {
        $currentRegistration = WorkshopRegistration::where('workshop_id', $workshop->id)->count();
        if ($currentRegistration >= $workshop->max_seats) {
            throw new \Exception('المقاعد ممتلئة لهذه الورشة');
        }
    }

    public function cancelRegistration(int $registrationId, int $userId): void
    {
        $registration = WorkshopRegistration::where('id', $registrationId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $registration->update(['status' => BookingStatus::CANCELLED->value]);
        $registration->delete();
    }

    public function getUserConfirmedRegisterations(int $userId): array
    {
        return WorkshopRegistration::where('user_id', $userId)
            ->where('status', BookingStatus::CONFIRMED->value)
            ->get(['id', 'workshop_id'])->toArray();
    }



}
