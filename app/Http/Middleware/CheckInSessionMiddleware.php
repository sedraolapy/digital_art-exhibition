<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\CheckIn\CheckInSessionService;
use Symfony\Component\HttpFoundation\Response;

class CheckInSessionMiddleware
{
    public function __construct(private CheckInSessionService $sessionService) {}

    public function handle(Request $request,Closure $next): Response
    {
        $token = $request->bearerToken();


        if (! $token) {
            return response()->json([
                'message' => 'Check-in session token required'
            ], 401);
        }

        $session = $this->sessionService->validate($token);

        if (! $session) {
            return response()->json([
                'message' => 'Invalid or expired check-in session'
            ], 401);
        }

        $request->attributes->set('checkInSession',$session);

        return $next($request);
    }
}