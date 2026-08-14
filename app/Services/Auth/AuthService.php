<?php

namespace App\Services\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\Exhibitor\SocialLinkService;
use App\Services\User\UserDataService;
use App\Services\User\UserQrService;
use App\Services\User\UserService;
use App\Services\Event\EventService;
use App\Services\Workshop\WorkshopRegistrationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class AuthService
{
    public function __construct(
        private SocialLinkService $socialLinkService,
        private UserDataService $userDataService,
        private UserQrService $userQrService,
        private UserService $userService,
        private EventService $eventService,
    ) {}


    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $user = $this->userService->createUser($data);

            $user->assignRole(RoleEnum::USER->value);
            $token = $user->createToken('auth_token')->plainTextToken;

            $profile = $user->userProfile()->first();
            $this->socialLinkService->attachLinks($profile, $data);
            $this->userQrService->generate($user);

            Log::channel('audit')->info('New user registered', [
                'user_id' => $user->id,
                'email'   => $user->email,
                'ip'      => request()->ip(),
            ]);


            return [
                'user' => $this->userDataService->loadAuthData($user),
                'token' => $token,
            ];
        });
    }


    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['البريد الإلكتروني أو كلمة المرور غير صحيحة.'],
            ]);
        }

        Log::channel('audit')->info('User logged in', [
            'user_id' => $user->id,
            'ip'      => request()->ip(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $this->userDataService->loadAuthData($user),
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        Log::channel('audit')->info('User logged out', ['user_id' => $user->id]);
        $user->tokens()->delete();
    }

}
