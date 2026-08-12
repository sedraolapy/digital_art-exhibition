<?php

namespace App\Http\Resources\User;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'token'      => $this->when(isset($this->token), $this->token),
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'role' => $this->getRoleNames()->first(),
            'qr_code'    => $this->qr_token,
            
            'voted_exhibitors' => $this->voted_exhibitors ?? [],
            'bookings'         => $this->bookings ?? [],
            'workshop_registrations' => $this->registrations  ?? [],
            'exhibitor_application_status' => $this->exhibitor_application_status,
            'is_checked_in' => $this->when(isset($this->is_checked_in),(bool) $this->is_checked_in),
            'exhibitor_events' => $this->exhibitor_events? $this->exhibitor_events->map(function ($profile) {
                return [
                    'event_id' => $profile->eventOccurrence->id,
                    'event_name' => $profile->eventOccurrence->title,
                    'event_location' => $profile->eventOccurrence->location->name,
                    'category' => $profile->category->name,
                    'start_date' => $profile->eventOccurrence->start_date,
                    'end_date' => $profile->eventOccurrence->end_date,
                ];
            }): [],
            'current_event' => $this->current_event ?? null,
        ];

    }
}
