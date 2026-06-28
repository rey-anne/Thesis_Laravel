<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Restricts a route to users whose role has been granted a given
 * permission key via the Roles & Permissions page, e.g.:
 *   Route::get('/admin/users', ...)->middleware('permission:manage_users');
 *
 * Superadmin always passes (see User::hasPermission()).
 * Registered as the 'permission' alias in bootstrap/app.php.
 */
class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();

        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'You do not have access to this page.');
        }

        return $next($request);
    }
}
