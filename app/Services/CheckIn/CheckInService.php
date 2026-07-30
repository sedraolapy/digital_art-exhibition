<?php

namespace App\Services\CeckIn;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\CheckInSession;
use App\Models\EventAttendance;
use App\Models\EventDay;
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

    private function handleLectureCheckIn(User $user,int $lectureId,CheckInSession $session): array {

        $lecture = Lecture::with('day')->find($lectureId);

        if (! $lecture) {
            return [
                'message' => 'المحاضرة غير موجودة',
                'data' => null,
            ];
        }

        if (! $this->lectureBelongsToEvent($lecture, $session)) {
            return [
                'message' => 'هذه المحاضرة لا تتبع لهذا الحدث',
                'data' => null,
            ];
        }

        if (! $this->hasConfirmedBooking($user, $lectureId)) {
            return [
                'message' => 'المستخدم غير مسجل على هذه المحاضرة',
                'data' => $user,
            ];
        }

        return $this->registerLectureAttendance($user,$lecture);
    }

    private function handleEventDayCheckIn(User $user,int $dayId,CheckInSession $session): array {

        $day = EventDay::find($dayId);

        if (! $day) {
            return [
                'message' => 'اليوم غير موجود',
                'data' => null,
            ];
        }

        if (! $this->dayBelongsToEvent($day, $session)) {
            return [
                'message' => 'هذا اليوم لا يتبع لهذا الحدث',
                'data' => null,
            ];
        }

        return $this->registerEventAttendance($user,$day);
    }

    private function lectureBelongsToEvent(Lecture $lecture,CheckInSession $session): bool {
        return $lecture->day->event_occurrences_id
            == $session->event_occurrence_id;
    }

    private function dayBelongsToEvent(EventDay $day,CheckInSession $session): bool {
        return $day->event_occurrences_id
            == $session->event_occurrence_id;
    }

    private function hasConfirmedBooking(User $user,int $lectureId): bool {

        return Booking::where('user_id', $user->id)
            ->where('lecture_id', $lectureId)
            ->where(
                'status',
                BookingStatus::CONFIRMED->value
            )
            ->exists();
    }

    private function registerLectureAttendance(User $user,Lecture $lecture): array {

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

    private function registerEventAttendance(User $user,EventDay $day): array {

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