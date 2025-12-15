<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     * Validates user authentication, active status, and role/permission requirements.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $permission  The required permission to access the route
     * @param  string|null  $role  The required role to access the route (optional)
     */
    public function handle(Request $request, Closure $next, ?string $permission = null, ?string $role = null): Response
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user account is active
        if (!$user->is_active) {
            Auth::logout();
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account has been deactivated. Please contact support for assistance.'
                ]);
        }

        // Check if user's client organization is active
        if ($user->client && !$user->client->is_active) {
            Auth::logout();
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your organization account has been deactivated. Please contact support for assistance.'
                ]);
        }

        // Check specific role requirement if provided
        if ($role && !$user->hasRole(UserRole::from($role))) {
            abort(403, 'Access denied. Your role does not have sufficient privileges to access this resource.');
        }

        // Check specific permission requirement if provided
        if ($permission && !$user->hasPermission($permission)) {
            abort(403, 'Access denied. You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
