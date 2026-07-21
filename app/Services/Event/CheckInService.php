<?php

namespace App\Services\Event;

use App\Enums\BookingStatus;
use App\Models\User;
use App\Models\EventAttendance;
use App\Models\LectureAttendance;
use App\Models\Booking;

class CheckInService
{
    public function checkIn(array $data): array
    {
        $user = User::where('qr_token', $data['qr_code'])->first();

        if (! $user) {
            return [
                'message' => 'QR غير صالح',
                'data'    => null,
            ];
        }

        if (!empty($data['lecture_id'])) {
            $hasBooking = Booking::where('user_id', $user->id)
                ->where('lecture_id', $data['lecture_id'])
                ->where('status', BookingStatus::CONFIRMED->value)
                ->exists();

            if (! $hasBooking) {
                return [
                    'message' => 'المستخدم غير مسجل على هذه المحاضرة',
                    'data'    => $user,
                ];
            }

            LectureAttendance::firstOrCreate([
                'user_id'   => $user->id,
                'lecture_id'=> $data['lecture_id'],
            ]);

            return [
                'message' => 'تم تسجيل الحضور للمحاضرة ',
                'data'    => $user,
            ];
        }

        if (!empty($data['event_day_id'])) {
            EventAttendance::firstOrCreate([
                'user_id'     => $user->id,
                'event_day_id'=> $data['event_day_id'],
            ]);

            return [
                'message' => 'تم تسجيل الحضور لليوم',
                'data'    => $user,
            ];
        }

        return [
            'message' => 'لم يتم تحديد نوع الحضور',
            'data'    => null,
        ];
    }
}
