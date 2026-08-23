<?php

namespace App\Services\Auth;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    public function verify(string $token): bool
    {
        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post(
                    'https://www.google.com/recaptcha/api/siteverify',
                    [
                        'secret' => config('services.recaptcha.secret'),
                        'response' => $token,
                    ]
                );

            return $response->successful()
                && ($response->json('success') ?? false);
        } catch (ConnectionException $e) {
            Log::warning('reCAPTCHA verification failed', [
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}