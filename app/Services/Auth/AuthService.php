<?php

namespace App\Services\Auth;

use App\Enums\Role;
use App\Events\UserRegistered;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthService
{
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

            $this->generateQrCode($user);
            event(new UserRegistered($user));

            $token = $user->createToken('auth_token')->plainTextToken;

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
