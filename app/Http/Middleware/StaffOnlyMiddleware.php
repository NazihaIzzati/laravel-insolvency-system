<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login');
        }

        $user = Auth::user();

        // Allow staff users and superusers to access main dashboard
        if (!$user->isStaff() && !$user->isSuperUser()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Access denied. Staff or Superuser privileges required.'], 403);
            }

            // Redirect admin users to admin dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Access denied. Admin users must use the admin dashboard.');
            }

            // Redirect ID management to their dashboard
            if ($user->isIdManagement()) {
                return redirect()->route('id-management.dashboard')
                    ->with('error', 'Access denied. ID Management users must use the ID Management dashboard.');
            }

            // For any other role, redirect to login
            return redirect()->route('login')
                ->with('error', 'Access denied. Invalid user role.');
        }

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account deactivated.'], 403);
            }

            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}
