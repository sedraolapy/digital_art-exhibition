<?php

namespace App\Services\Auth;

use App\Events\ForgotPasswordRequested;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ForgotPasswordService
{
    public function sendResetLink(string $email): void
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            Log::channel('security')->info('Password reset requested for non-existent email', [
                'email' => $email,
                'ip'    => request()->ip(),
            ]);
            return;
        }

        Log::channel('audit')->info('Password reset link sent', [
            'user_id' => $user->id,
            'ip'      => request()->ip(),
        ]);

        $token = Password::createToken($user);

        event(new ForgotPasswordRequested($user, $token));
    }


    public function resetPassword(array $data): void
    {
        $status = Password::reset(
            $data,
            function ($user) use ($data) {
                $user->forceFill([
                    'password' => Hash::make($data['password']),
                    'remember_token' => Str::random(60),
                ])->save();

                Log::channel('security')->warning('Password was reset', [
                    'user_id' => $user->id,
                    'ip'      => request()->ip(),
                ]);

                event(new PasswordReset($user));
            }
        );


        if ($status !== Password::PASSWORD_RESET) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }
}