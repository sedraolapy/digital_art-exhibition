<?php

namespace App\Http\Resources\User;

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
            'social_links'     => $this->socialLinks->map(function ($link) {
                return [
                    'platform' => $link->platform,
                    'url'      => $link->url,
                ];
            })??null,
            'role'       => $this->role,
            'qr_code'    => $this->qr_token,
            'voted_exhibitors' => $this->voted_exhibitors ?? [],
            'bookings'         => $this->bookings ?? [],
            'exhibitor_application_status' => $this->exhibitor_application_status,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
