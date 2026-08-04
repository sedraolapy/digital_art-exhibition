<?php

namespace App\Services\Lecture;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Lecture;
use App\Services\Event\EventService;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(private EventService $eventService) {}

    public function createBooking(int $userId, int $lectureId): Booking
    {
        return DB::transaction(function () use ($userId, $lectureId) {
            $lecture = $this->lockLecture($lectureId);
            $eventOccurrenceId = $lecture->day->event_occurrence_id;

            $this->checkDuplicateBooking($userId, $lectureId);
            $this->checkMaxBookings($userId, $eventOccurrenceId);
            $this->checkLectureNotEnded($lecture);
            $this->checkSeatsAvailability($lecture);

            return Booking::create([
                'user_id'    => $userId,
                'lecture_id' => $lectureId,
                'status'     => BookingStatus::CONFIRMED->value,
            ]);
        });
    }

    public function cancelBooking(int $bookingId, int $userId): void
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $booking->update(['status' => BookingStatus::CANCELLED->value]);
        $booking->delete();
    }

    public function getUserConfirmedBookings(int $userId): array
    {
        $activeEvent = $this->eventService->getActiveEvent();

        if (! $activeEvent) {
            return [];
        }

        return Booking::where('user_id', $userId)
            ->where('status', BookingStatus::CONFIRMED->value)
            ->whereHas('lecture.day', fn($query) =>
                $query->where('event_occurrence_id', $activeEvent->id)
            )->get(['id', 'lecture_id'])->toArray();
    }

    // 🔹 دوال خاصة للتحقق
    private function checkDuplicateBooking(int $userId, int $lectureId): void
    {
        if (Booking::where('user_id', $userId)->where('lecture_id', $lectureId)->exists()) {
            throw new \Exception('لقد قمت بحجز هذه المحاضرة مسبقاً');
        }
    }

    private function checkMaxBookings(int $userId, int $eventOccurrenceId): void
    {
        $count = Booking::where('user_id', $userId)
            ->whereHas('lecture.day', fn($query) =>
                $query->where('event_occurrence_id', $eventOccurrenceId)
            )->count();

        if ($count >= 3) {
            throw new \Exception('لا يمكنك حجز أكثر من 3 محاضرات في نفس الحدث');
        }
    }

    private function lockLecture(int $lectureId): Lecture
    {
        return Lecture::whereKey($lectureId)->lockForUpdate()->firstOrFail();
    }

    private function checkSeatsAvailability(Lecture $lecture): void
    {
        $currentBookings = Booking::where('lecture_id', $lecture->id)->count();
        if ($currentBookings >= $lecture->max_seats) {
            throw new \Exception('المقاعد ممتلئة لهذه المحاضرة');
        }
    }

    private function checkLectureNotEnded(Lecture $lecture): void
    {
        if ($lecture->hasEnded) {
            throw new \Exception('انتهى وقت التسجيل لهذه المحاضرة');
        }
    }
}
