<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Restricts a route to one or more roles, e.g.:
 *   Route::get('/admin/home', ...)->middleware('auth', 'role:admin,superadmin');
 *
 * Registered as the 'role' alias in bootstrap/app.php.
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'You do not have access to this page.');
        }

        return $next($request);
    }
}
