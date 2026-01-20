<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PasswordChangeConfirmationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    /**
     * Show the password reset form.
     */
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (!$token || !$email) {
            return redirect()->route('login')
                ->with('error', 'Invalid password reset link.');
        }

        $user = User::where('email', $email)->first();
        
        if (!$user || !$user->isValidPasswordResetToken($token)) {
            return redirect()->route('login')
                ->with('error', 'Invalid or expired password reset link.');
        }

        return view('auth.password-reset', compact('token', 'email'));
    }

    /**
     * Handle password reset form submission.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:12|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();
        
        if (!$user || !$user->isValidPasswordResetToken($request->token)) {
            return redirect()->route('login')
                ->with('error', 'Invalid or expired password reset link.');
        }

        // Update user's password
        $user->update([
            'password' => Hash::make($request->password),
            'pwdchange_date' => now(),
            'last_modified_date' => now(),
            'last_modified_user' => $user->name,
        ]);

        // Clear the reset token
        $user->clearPasswordResetToken();

        // Send password change confirmation email
        try {
            $user->notify(new PasswordChangeConfirmationNotification('You', 'reset_link'));
            \Log::info('Password change confirmation email sent successfully to: ' . $user->email);
        } catch (\Exception $e) {
            // Log the error but don't fail the password reset
            \Log::error('Failed to send password change confirmation email: ' . $e->getMessage());
        }

        // Log out the user if they are currently logged in (to avoid confusion)
        if (Auth::check() && Auth::id() == $user->id) {
            Auth::logout();
        }

        // Show success message on the password reset page instead of redirecting
        return view('auth.password-reset', [
            'token' => $request->token,
            'email' => $request->email,
            'success' => true,
            'message' => 'Your password has been reset successfully. A confirmation email has been sent to ' . $user->email . '. You can now log in with your new password.'
        ]);
    }
}