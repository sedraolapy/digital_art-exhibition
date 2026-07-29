<?php

namespace App\Http\Middleware;

use App\Models\CheckInSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json([
                'message' => 'Check-in session token required'
            ], 401);
        }

        $session = CheckInSession::where('token', $token)
            ->where('is_active', true)
            ->first();

        if (! $session) {
            return response()->json([
                'message' => 'Invalid check-in session'
            ], 401);
        }

        if ($session->expires_at->isPast()) {

            return response()->json([
                'message' => 'Check-in session expired'
            ], 401);

        }

        $request->merge([
            'checkInSession' => $session,
        ]);

        return $next($request);
    }
}
