<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureClientAccess
{
    /**
     * Handle an incoming request.
     * Ensures that users can only access data from their own client organization.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Super admins can access all clients
        if ($user->hasRole(\App\Enums\UserRole::SUPER_ADMIN)) {
            return $next($request);
        }

        // Ensure user has a client assigned
        if (!$user->client_id) {
            // Log out the user and redirect with error message
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account is not associated with any organization. Please contact support for assistance.'
                ]);
        }

        // Check if the user's client organization is active
        if ($user->client && !$user->client->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your organization account has been deactivated. Please contact support for assistance.'
                ]);
        }

        // Add client_id to request parameters for automatic filtering
        $request->merge(['client_id' => $user->client_id]);

        // Store client context in session for easy access
        session(['current_client_id' => $user->client_id]);

        return $next($request);
    }
}
