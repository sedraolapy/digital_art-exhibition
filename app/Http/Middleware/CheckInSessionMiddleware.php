<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\CheckIn\CheckInSessionService;
use Symfony\Component\HttpFoundation\Response;

class CheckInSessionMiddleware
{
    public function __construct(private CheckInSessionService $sessionService) {}

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json([
                'message' => 'Check-in session token required'
            ], 401);
        }

        $deviceId = $request->header('X-Device-ID');

        if (! $deviceId) {
            return response()->json([
                'message' => 'Device ID header is required'
            ], 401);
        }

        $session = $this->sessionService->validate($token, $deviceId);

        if (! $session) {
            return response()->json([
                'message' => 'Invalid, expired, or unverified check-in session. Call GET /check-in/session first.'
            ], 401);
        }

        $request->attributes->set('checkInSession', $session);

        return $next($request);
    }
}
