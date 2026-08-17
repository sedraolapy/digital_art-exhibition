<?php

namespace App\Services\Lecture;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Lecture;
use App\Services\Event\EventService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class BookingService
{
    public function __construct(private EventService $eventService) {}

    public function createBooking(int $userId, int $lectureId): Booking
    {
        $lockKey = "booking-lock:{$userId}:{$lectureId}";
        $lock = Cache::store('redis')->lock($lockKey, 10);

        if (! $lock->get()) {
            Log::channel('performance')->warning('Failed to acquire booking lock', [
                'user_id' => $userId,
                'lecture_id' => $lectureId,
            ]);

            throw new \Exception('النظام مشغول حالياً، حاول مجدداً بعد لحظات');
        }

        try {
            return DB::transaction(function () use ($userId, $lectureId) {
                $lecture = $this->lockLecture($lectureId);
                $eventOccurrenceId = $lecture->day->event_occurrence_id;

                $this->checkLectureBelongsToActiveEvent($eventOccurrenceId);
                $this->checkDuplicateBooking($userId, $lectureId);
                $this->checkMaxBookings($userId, $eventOccurrenceId);
                $this->checkLectureNotEnded($lecture);
                $this->checkSeatsAvailability($lecture);

                $booking = Booking::create([
                    'user_id'    => $userId,
                    'lecture_id' => $lectureId,
                    'status'     => BookingStatus::CONFIRMED->value,
                ]);

                Log::channel('audit')->info('Booking created', [
                    'user_id' => $userId,
                    'lecture_id' => $lectureId,
                    'booking_id' => $booking->id,
                ]);

                return $booking;
            });
        } catch (\Exception $e) {
            Log::channel('security')->info('Booking attempt failed', [
                'user_id' => $userId,
                'lecture_id' => $lectureId,
                'reason' => $e->getMessage(),
            ]);
            throw $e;
        } finally {
            $lock->release();
        }
    }

    public function cancelBooking(int $bookingId, int $userId): void
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $booking->update(['status' => BookingStatus::CANCELLED->value]);
        $booking->delete();

        Log::channel('audit')->info('Booking cancelled', [
            'booking_id' => $bookingId,
            'user_id'    => $userId,
        ]);
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

    private function checkLectureBelongsToActiveEvent(int $eventOccurrenceId): void
    {
        $activeEvent = $this->eventService->getActiveEvent();

        if (! $activeEvent || $activeEvent->id !== $eventOccurrenceId) {
            throw new \Exception('لا يمكنك حجز محاضرة تابعة لحدث غير فعّال');
        }
    }

    private function checkDuplicateBooking(int $userId, int $lectureId): void
    {
        if (
            Booking::where('user_id', $userId)
                ->where('lecture_id', $lectureId)
                ->where('status', BookingStatus::CONFIRMED->value)
                ->exists()) {
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
        $startedAt = microtime(true);

        try {
            $lecture = Lecture::whereKey($lectureId)->lockForUpdate()->firstOrFail();
        } catch (QueryException $e) {
            Log::channel('performance')->error('Failed to lock lecture row (deadlock or timeout)', [
                'lecture_id' => $lectureId,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('النظام مشغول حالياً، حاول مجدداً بعد لحظات');
        }

        $waitTime = microtime(true) - $startedAt;

        if ($waitTime > 0.5) {
            Log::channel('performance')->warning('High contention on lecture lock', [
                'lecture_id' => $lectureId,
                'wait_seconds' => round($waitTime, 3),
            ]);
        }

        return $lecture;
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
