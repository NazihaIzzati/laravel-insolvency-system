<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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

        if (!$user->hasAdminPrivileges()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Access denied. Admin privileges required.'], 403);
            }

            // Redirect ID management to their dashboard
            if ($user->isIdManagement()) {
                return redirect()->route('id-management.dashboard')
                    ->with('error', 'Access denied. ID Management users must use the ID Management dashboard.');
            }

            // Redirect staff to main dashboard
            if ($user->isStaff()) {
                return redirect()->route('dashboard')
                    ->with('error', 'Access denied. Staff users must use the main dashboard.');
            }

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
