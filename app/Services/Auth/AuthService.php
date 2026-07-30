<?php

namespace App\Services\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\Exhibitor\SocialLinkService;
use App\Services\User\UserDataService;
use App\Services\User\UserQrService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthService
{
    public function __construct(
        private SocialLinkService $socialLinkService,
        private UserDataService $userDataService,
        private UserQrService $userQrService,
    ) {}


    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $user = $this->createUser($data);
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
        $user = User::where('email',$data['email'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        if (! $user ||! Hash::check($data['password'],$user->password))
        {
            throw ValidationException::withMessages([
                'email' => [
                    'The provided credentials are incorrect.'
                ],
            ]);
        }

        return [
            'user' => $this->userDataService->loadAuthData($user),
            'token' => $token ,
        ];
    }




    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }




    private function createUser(array $data): User
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => Hash::make(
                $data['password']
            ),
        ]);
    }

}