<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    /**
     * Show the change password form
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'Current password is required.',
            'current_password.current_password' => 'The current password is incorrect.',
            'password.required' => 'New password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect to appropriate dashboard based on user role
        $redirectRoute = $this->getRedirectRouteForUser($user);
        return redirect($redirectRoute)->with('success', 'Password changed successfully!');
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
        
        // Super users go to admin dashboard
        if ($user->isSuperUser()) {
            return route('admin.dashboard');
        }
        
        // All other users go to main dashboard
        return route('dashboard');
    }
}
