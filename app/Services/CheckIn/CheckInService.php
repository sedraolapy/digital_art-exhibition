<?php

namespace App\Services\CheckIn;

use App\Enums\BookingStatus;
use App\Enums\EventOccurrenceStatus;
use App\Enums\WorkshopStatus;
use App\Models\Booking;
use App\Models\CheckInSession;
use App\Models\EventAttendance;
use App\Models\EventDay;
use App\Models\EventOccurrence;
use App\Models\Lecture;
use App\Models\LectureAttendance;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopAttendance;
use App\Models\WorkshopRegistration;
use App\Services\Event\EventService;

class CheckInService
{
    public function __construct(private EventService $eventService) {}

    public function checkIn(array $data, CheckInSession $session): array
    {
        $user = $this->findUser($data['qr_code']);

        if (! $user) {
            return [
                'message' => 'QR غير صالح',
                'data' => null
            ];
        }

        if (! empty($data['lecture_id'])) {
            return $this->handleLectureCheckIn($user, $data['lecture_id'], $session);
        }

        if (! empty($data['workshop_id'])) {
            return $this->handleWorkshopCheckIn($user, $data['workshop_id'], $session);
        }

        if (! empty($data['event_day_id'])) {
            return $this->handleEventDayCheckIn($user, $data['event_day_id'], $session);
        }

        return [
            'message' => 'لم يتم تحديد نوع الحضور',
            'data' => null
        ];
    }

    private function findUser(string $qrCode): ?User
    {
        return User::where('qr_token', $qrCode)->first();
    }

    private function handleLectureCheckIn(User $user, int $lectureId, CheckInSession $session): array
    {
        $lecture = Lecture::with('day')
            ->whereKey($lectureId)
            ->whereHas('day', fn($query) =>
                $query->where('event_occurrence_id', $session->event_occurrence_id)
            )
            ->first();

        if (! $lecture) {
            return [
                'message' => 'هذه المحاضرة لا تتبع للحدث الحالي',
                'data' => null
            ];
        }

        if (! $this->hasConfirmedBooking($user, $lecture->id)) {
            return [
                'message' => 'المستخدم غير مسجل على هذه المحاضرة',
                'data' => null
            ];
        }

        return $this->registerLectureAttendance($user, $lecture);
    }


    private function handleWorkshopCheckIn(User $user, int $workshopId, CheckInSession $session): array
    {
        $workshop = Workshop::whereKey($workshopId)->where('status', WorkshopStatus::ACTIVE->value)->first();

        if (! $workshop) {
            return [
                'message' => 'هذه الورشة غير متاحة',
                'data' => null
            ];
        }

        if (! $this->hasConfirmedRegistration($user, $workshop->id)) {
            return [
                'message' => 'المستخدم غير مسجل على هذه الورشة',
                'data' => null
            ];
        }

        return $this->registerWorkshopAttendance($user, $workshop);
    }

    private function handleEventDayCheckIn(User $user, int $dayId, CheckInSession $session): array
    {
        $event = EventOccurrence::whereKey($session->event_occurrence_id)
            ->where('status', EventOccurrenceStatus::ACTIVE->value)
            ->first();

        if (! $event) {
            return [
                'message' => 'الحدث غير نشط',
                'data' => null
            ];
        }

        $day = EventDay::whereKey($dayId)
            ->where('event_occurrence_id', $event->id)
            ->first();

        if (! $day) {
            return [
                'message' => 'هذا اليوم لا يتبع للحدث الحالي',
                'data' => null
            ];
        }

        return $this->registerEventAttendance($user, $day);
    }

    private function hasConfirmedBooking(User $user, int $lectureId): bool
    {
        return Booking::where('user_id', $user->id)
            ->where('lecture_id', $lectureId)
            ->where('status', BookingStatus::CONFIRMED->value)
            ->exists();
    }

    private function hasConfirmedRegistration(User $user, int $workshopId): bool
    {
        return WorkshopRegistration::where('user_id', $user->id)
            ->where('workshop_id', $workshopId)
            ->where('status', BookingStatus::CONFIRMED->value)
            ->exists();
    }

    private function registerLectureAttendance(User $user, Lecture $lecture): array
    {
        $attendance = LectureAttendance::firstOrCreate([
            'user_id' => $user->id,
            'lecture_id' => $lecture->id,
        ]);

        if (! $attendance->wasRecentlyCreated) {
            return [
                'message' => 'تم تسجيل حضور المستخدم مسبقاً لهذه المحاضرة',
                'data' => $user
            ];
        }

        return [
            'message' => 'تم تسجيل الحضور للمحاضرة بنجاح',
            'data' => $user
        ];
    }

    private function registerWorkshopAttendance(User $user, Workshop $workshop): array
    {
        $attendance = WorkshopAttendance::firstOrCreate([
            'user_id' => $user->id,
            'workshop_id' => $workshop->id,
        ]);

        if (! $attendance->wasRecentlyCreated) {
            return [
                'message' => 'تم تسجيل حضور المستخدم مسبقاً لهذه الورشة',
                'data' => $user
            ];
        }

        return [
            'message' => 'تم تسجيل الحضور للورشة بنجاح',
            'data' => $user
        ];
    }

    private function registerEventAttendance(User $user, EventDay $day): array
    {
        $attendance = EventAttendance::firstOrCreate([
            'user_id' => $user->id,
            'event_day_id' => $day->id,
        ]);

        if (! $attendance->wasRecentlyCreated) {
            return [
                'message' => 'تم تسجيل حضور المستخدم مسبقاً لهذا اليوم',
                'data' => $user
            ];
        }

        return [
            'message' => 'تم تسجيل الحضور لليوم بنجاح',
            'data' => $user
        ];
    }

    public function hasCheckedIn(User $user): bool
    {
        $event = $this->eventService->getActiveEvent();
        if (! $event) {
            return false;
        }

        return $user->eventAttendances()
            ->whereHas('eventDay', fn($query) =>
                $query->where('event_occurrence_id', $event->id)
            )->exists();
    }
}
