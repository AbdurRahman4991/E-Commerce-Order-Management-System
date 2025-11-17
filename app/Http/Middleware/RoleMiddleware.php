<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // role_id → role name mapping
        $roleMap = [
            1 => 'admin',
            2 => 'vendor',
            3 => 'customer',
        ];

        $userRole = $roleMap[$user->role_id] ?? null;

        if (!$userRole || !in_array($userRole, $roles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return $next($request);
    }
}
