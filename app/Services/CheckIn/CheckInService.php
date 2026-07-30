<?php

namespace App\Services\CheckIn;

use App\Enums\BookingStatus;
use App\Enums\EventOccurrenceStatus;
use App\Models\Booking;
use App\Models\CheckInSession;
use App\Models\EventAttendance;
use App\Models\EventDay;
use App\Models\EventOccurrence;
use App\Models\Lecture;
use App\Models\LectureAttendance;
use App\Models\User;

class CheckInService
{
    public function checkIn(array $data, CheckInSession $session): array
    {
        $user = $this->findUser($data['qr_code']);

        if (! $user) {
            return [
                'message' => 'QR غير صالح',
                'data' => null,
            ];
        }

        if (! empty($data['lecture_id'])) {
            return $this->handleLectureCheckIn(
                $user,
                $data['lecture_id'],
                $session
            );
        }

        if (! empty($data['event_day_id'])) {
            return $this->handleEventDayCheckIn(
                $user,
                $data['event_day_id'],
                $session
            );
        }

        return [
            'message' => 'لم يتم تحديد نوع الحضور',
            'data' => null,
        ];
    }

    private function findUser(string $qrCode): ?User
    {
        return User::where('qr_token', $qrCode)->first();
    }

    private function handleLectureCheckIn(
        User $user,
        int $lectureId,
        CheckInSession $session
    ): array {

        $lecture = Lecture::with('day')
            ->whereKey($lectureId)
            ->whereHas('day', function ($query) use ($session) {
                $query->where(
                    'event_occurrence_id',
                    $session->event_occurrence_id
                );
            })
            ->first();

        if (! $lecture) {
            return [
                'message' => 'هذه المحاضرة لا تتبع للحدث الحالي',
                'data' => null,
            ];
        }

        if (! $this->hasConfirmedBooking($user, $lecture->id)) {
            return [
                'message' => 'المستخدم غير مسجل على هذه المحاضرة',
                'data' => null,
            ];
        }

        return $this->registerLectureAttendance(
            $user,
            $lecture
        );
    }

    private function handleEventDayCheckIn(
        User $user,
        int $dayId,
        CheckInSession $session
    ): array {

        $event = EventOccurrence::whereKey($session->event_occurrence_id)
            ->where('status', EventOccurrenceStatus::ACTIVE->value)
            ->first();

        if (! $event) {
            return [
                'message' => 'الحدث غير نشط',
                'data' => null,
            ];
        }

        $day = EventDay::whereKey($dayId)
            ->where('event_occurrence_id', $event->id)
            ->first();

        if (! $day) {
            return [
                'message' => 'هذا اليوم لا يتبع للحدث الحالي',
                'data' => null,
            ];
        }

        return $this->registerEventAttendance(
            $user,
            $day
        );
    }

    private function hasConfirmedBooking(
        User $user,
        int $lectureId
    ): bool {

        return Booking::where('user_id', $user->id)
            ->where('lecture_id', $lectureId)
            ->where(
                'status',
                BookingStatus::CONFIRMED->value
            )
            ->exists();
    }

    private function registerLectureAttendance(
        User $user,
        Lecture $lecture
    ): array {

        $attendance = LectureAttendance::firstOrCreate([
            'user_id' => $user->id,
            'lecture_id' => $lecture->id,
        ]);

        if (! $attendance->wasRecentlyCreated) {
            return [
                'message' => 'تم تسجيل حضور المستخدم مسبقاً لهذه المحاضرة',
                'data' => $user,
            ];
        }

        return [
            'message' => 'تم تسجيل الحضور للمحاضرة بنجاح',
            'data' => $user,
        ];
    }

    private function registerEventAttendance(
        User $user,
        EventDay $day
    ): array {

        $attendance = EventAttendance::firstOrCreate([
            'user_id' => $user->id,
            'event_day_id' => $day->id,
        ]);

        if (! $attendance->wasRecentlyCreated) {
            return [
                'message' => 'تم تسجيل حضور المستخدم مسبقاً لهذا اليوم',
                'data' => $user,
            ];
        }

        return [
            'message' => 'تم تسجيل الحضور لليوم بنجاح',
            'data' => $user,
        ];
    }
}