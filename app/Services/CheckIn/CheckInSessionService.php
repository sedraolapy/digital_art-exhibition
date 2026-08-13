<?php

namespace App\Services\CheckIn;

use App\Models\CheckInSession;
use Illuminate\Http\Request;

class CheckInSessionService
{
    public function validateSession(Request $request): array
    {
        $token = $request->bearerToken();
        if (! $token) {
            return ['message' => 'Session token is required', 'data' => null];
        }

        $session = CheckInSession::where('token_hash', hash('sha256', $token))
            ->where('is_active', true)
            ->first();

        if (! $session) {
            return ['message' => 'Invalid or expired session', 'data' => null];
        }

        if ($session->expires_at && now()->greaterThan($session->expires_at)) {
            $session->update(['is_active' => false]);
            return ['message' => 'Session expired', 'data' => null];
        }

        $deviceId = $request->header('X-Device-ID');
        if (! $deviceId) {
            return ['message' => 'Device ID is required', 'data' => null];
        }

        if (! $session->device_id) {
            $session->update(['device_id' => $deviceId]);
        } elseif ($session->device_id !== $deviceId) {
            return ['message' => 'This session is already used on another device', 'data' => null];
        }

        return [
            'message' => 'Session is valid',
            'data' => [
                'check_in_type' => $session->check_in_type,
                'expires_at' => $session->expires_at,
            ],
        ];
    }

    public function validate(string $token, ?string $deviceId = null): ?CheckInSession
    {
        $session = CheckInSession::where('token_hash', hash('sha256', $token))
            ->where('is_active', true)
            ->first();

        if (! $session) {
            return null;
        }

        if ($session->expires_at && $session->expires_at->isPast()) {
            $session->update(['is_active' => false]);
            return null;
        }

        if (! $session->device_id) {
            return null;
        }

        if (! $deviceId || $session->device_id !== $deviceId) {
            return null;
        }

        return $session;
    }
}
