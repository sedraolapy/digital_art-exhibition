<?php

namespace App\Services\Booking;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Lecture;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function createBooking(int $userId, int $lectureId): Booking
    {
        return DB::transaction(function () use ($userId, $lectureId) {

            $lecture = $this->lockLecture($lectureId);

            $eventOccurrenceId = $lecture->day->event_occurrence_id;

            $this->checkDuplicateBooking($userId, $lectureId);

            $this->checkMaxBookings($userId,$eventOccurrenceId);

            $this->checkLectureNotEnded($lecture);

            $this->checkSeatsAvailability($lecture);


            return Booking::create([
                'user_id'    => $userId,
                'lecture_id' => $lectureId,
                'status'     => BookingStatus::CONFIRMED->value,
            ]);
        });
    }
    private function checkDuplicateBooking(int $userId, int $lectureId): void
    {
        $existing = Booking::where('user_id', $userId)
            ->where('lecture_id', $lectureId)
            ->first();

        if ($existing) {
            throw new \Exception('لقد قمت بحجز هذه المحاضرة مسبقًا');
        }
    }

    private function checkMaxBookings(int $userId, int $eventOccurrenceId): void
    {
        $count = Booking::where('user_id', $userId)
            ->whereHas('lecture.day', function ($query) use ($eventOccurrenceId) {
                $query->where('event_occurrence_id', $eventOccurrenceId);
            })
            ->count();

        if ($count >= 3) {
            throw new \Exception('لا يمكنك حجز أكثر من 3 محاضرات في نفس الحدث');
        }
    }


    private function lockLecture(int $lectureId): Lecture
    {
        return Lecture::where('id', $lectureId)->lockForUpdate()->firstOrFail();
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



    public function cancelBooking(int $bookingId): void
    {
        $booking = Booking::where('id', $bookingId)
            ->firstOrFail();

            $booking->status = BookingStatus::CANCELLED->value;
            $booking->save();
            $booking->delete();
    }


    public function getUserConfirmedBookings(int $userId): array
    {
        return Booking::where('user_id', $userId)
            ->where('status', BookingStatus::CONFIRMED->value)
            ->get(['id', 'lecture_id'])
            ->toArray();
    }
}
