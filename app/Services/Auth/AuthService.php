<?php

namespace App\Services\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\Exhibitor\SocialLinkService;
use App\Services\User\UserDataService;
use App\Services\User\UserQrService;
use App\Services\User\UserService;
use App\Services\Workshop\WorkshopRegistrationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthService
{
    public function __construct(
        private SocialLinkService $socialLinkService,
        private UserDataService $userDataService,
        private UserQrService $userQrService,
        private UserService $userService,
    ) {}


    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $user = $this->userService->createUser($data);

            $user->assignRole(RoleEnum::USER->value);
            $token = $user->createToken('auth_token')->plainTextToken;

            $this->socialLinkService->attachLinks($user, $data);
            $this->userQrService->generate($user);

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
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $this->userDataService->loadAuthData($user),
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }

}
