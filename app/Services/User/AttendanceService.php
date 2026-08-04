<?php

namespace App\Services\User;

use App\Models\User;

class AttendanceService
{
    public function getAttendance(User $user): array
    {
        return [
            'lectures' => $user->lectureAttendance()
                ->with('lecture')
                ->latest()
                ->get(),

            'workshops' => $user->workshopAttendance()
                ->with('workshop')
                ->latest()
                ->get(),
        ];
    }
}