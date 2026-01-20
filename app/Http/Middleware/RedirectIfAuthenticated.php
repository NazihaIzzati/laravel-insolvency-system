<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $redirectRoute = $this->getRedirectRouteForUser($user);
                return redirect($redirectRoute);
            }
        }

        return $next($request);
    }

    /**
     * Get the appropriate redirect route for a user based on their role.
     *
     * @param \App\Models\User $user
     * @return string
     */
    private function getRedirectRouteForUser($user)
    {
        // ID Management users go to their dedicated dashboard
        if ($user->isIdManagement()) {
            return route('id-management.dashboard');
        }
        
        // Admin users go to admin dashboard
        if ($user->isAdmin()) {
            return route('admin.dashboard');
        }
        
        // Super users go to main dashboard (can access all functions)
        if ($user->isSuperUser()) {
            return route('dashboard');
        }
        
        // All other users go to main dashboard
        return route('dashboard');
    }
}
