<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        $allowedRoles = preg_split('/[,\|]/', $roles);
        $allowedRoles = array_map(fn($r) => Role::from(trim($r)), $allowedRoles);

        if (! $user || ! in_array($user->role, $allowedRoles)) {
            return response()->json([
                'message' => 'غير مصرح لك بالدخول. الدور المطلوب: ' . $roles,
            ], 403);
        }

        return $next($request);
    }
}
