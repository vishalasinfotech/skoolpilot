<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if ($roles === []) {
            return $next($request);
        }

        $userRole = str_replace('-', '_', (string) $user->role);
        $allowedRoles = array_map(
            static fn (string $role): string => str_replace('-', '_', $role),
            $roles
        );

        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
