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
            $this->checkDuplicateBooking($userId, $lectureId);
            $this->checkMaxBookings($userId);
            $lecture = $this->lockLecture($lectureId);
            $this->checkLectureNotEnded($lecture);
            $this->checkSeatsAvailability($lecture);

            $booking = Booking::create([
                'user_id'    => $userId,
                'lecture_id' => $lectureId,
                'status'     => BookingStatus::CONFIRMED->value,
            ]);

            return $booking;
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

    private function checkMaxBookings(int $userId): void
    {
        $count = Booking::where('user_id', $userId)->count();
        if ($count >= 3) {
            throw new \Exception('لا يمكنك حجز أكثر من 3 محاضرات');
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
        $lectureEndDateTime = Carbon::parse($lecture->end_time);

        if (now()->greaterThan($lectureEndDateTime)) {
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
