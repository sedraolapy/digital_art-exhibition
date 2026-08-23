<?php

namespace App\Services\Workshop;

use App\Models\Workshop;
use App\Enums\BookingStatus;

class WorkshopService
{
    public function getWorkshops(){

        return Workshop::with('media')
            ->withCount([
                'registrations' => fn ($query) =>
                    $query->where(
                        'status',
                        BookingStatus::CONFIRMED->value
                    ),
            ])
            ->get();
    }
}
