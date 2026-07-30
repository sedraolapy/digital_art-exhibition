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
            // أول استدعاء لـ GET هو يلي بيربط الجلسة بهاد الجهاز
            $session->update(['device_id' => $deviceId]);
        } elseif ($session->device_id !== $deviceId) {
            return ['message' => 'This session is already used on another device', 'data' => null];
        }

        return [
            'message' => 'Session is valid',
            'data' => [
                'event_occurrence_id' => $session->event_occurrence_id,
                'expires_at' => $session->expires_at,
            ],
        ];
    }

    /**
     * تستخدم من الـ middleware لحماية أي endpoint حساس (زي POST /check-in).
     *
     * بترفض الطلب إذا:
     * - التوكن غير صالح / منتهي
     * - الجهاز لسا ما انربط بالجلسة (يعني GET /check-in/session ما انعملها استدعاء أبداً)
     * - الجهاز المرسل مش نفس الجهاز يلي انربط بالجلسة أول مرة
     */
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

        // ما في ربط جهاز أصلاً؟ يعني الـ handshake (GET) ما صار بعد -> ممنوع
        if (! $session->device_id) {
            return null;
        }

        // ما إجا device id بالهيدر، أو مش مطابق للجهاز الموثّق -> ممنوع
        if (! $deviceId || $session->device_id !== $deviceId) {
            return null;
        }

        return $session;
    }
}
