<?php

namespace App\Services\Auth;

use App\Enums\BookingStatus;
use App\Enums\EventOccurrenceStatus;
use App\Enums\Role;
use App\Events\UserRegistered;
use App\Models\Booking;
use App\Models\EventOccurrence;
use App\Models\ExhibitorApplication;
use App\Models\User;
use App\Models\Vote;
use App\Services\Booking\BookingService;
use App\Services\Exhibitor\SocialLinkService;
use App\Services\Exhibitor\VoteService;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthService
{
    private SocialLinkService $socialLinkService;
    private VoteService $voteService;
    private BookingService $bookingService;

    public function __construct(SocialLinkService $socialLinkService, VoteService $voteService, BookingService $bookingService)
    {
        $this->socialLinkService = $socialLinkService;
        $this->voteService = $voteService;
        $this->bookingService = $bookingService;
    }

    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'email'      => $data['email'],
                'phone'      => $data['phone'],
                'password'   => Hash::make($data['password']),
                'role'       => Role::USER->value,
            ]);

            $this->socialLinkService->attachLinks($user, $data);

            $this->generateQrCode($user);

            event(new UserRegistered($user));
            $token = $user->createToken('auth_token')->plainTextToken;

            $user->voted_exhibitors = [];
            $user->bookings = [];

            $user->exhibitor_application_status = ExhibitorApplication::where('user_id', $user->id)
                ->value('status');

            return [
                'user'  => $user->fresh(),
                'token' => $token,
            ];
        });
    }

    private function generateQrCode(User $user): void
    {
        $uuid = Str::uuid()->toString();

        $user->update([
            'qr_token' => $uuid,
        ]);
    }


    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $votedExhibitors = $this->voteService->getUserVotesForActiveOccurrence($user->id);
        $bookings = $this->bookingService->getUserConfirmedBookings($user->id);
        $applicationStatus = ExhibitorApplication::where('user_id', $user->id)->value('status');

        $user->voted_exhibitors = $votedExhibitors;
        $user->bookings = $bookings;
        $user->exhibitor_application_status = $applicationStatus;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }


    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}
