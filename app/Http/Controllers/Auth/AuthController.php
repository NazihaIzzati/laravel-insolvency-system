<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $redirectRoute = $this->getRedirectRouteForUser($user);
            return redirect($redirectRoute);
        }
        
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required|string',
            'password' => 'required|string|min:12',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('staff_id', 'password');
        $remember = $request->boolean('remember');

        try {
            $user = $this->authService->attemptLogin($credentials, $remember);
            
            if ($user) {
                $request->session()->regenerate();
                
                // Log the login
                AuditService::logLogin($user, $request);
                
                // Redirect based on user role
                $redirectRoute = $this->getRedirectRouteForUser($user);
                
                return redirect()->intended($redirectRoute)
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            }
            
            throw ValidationException::withMessages([
                'staff_id' => ['The provided credentials do not match our records.'],
            ]);
            
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->except('password'));
        }
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $redirectRoute = $this->getRedirectRouteForUser($user);
            return redirect($redirectRoute);
        }
        
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:12|confirmed',
            'role' => 'nullable|string|in:user,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            $user = $this->authService->register($request->all());
            
            Auth::login($user);
            $request->session()->regenerate();
            
            return redirect()->route('dashboard')
                ->with('success', 'Account created successfully! Welcome, ' . $user->name . '!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log the logout before clearing the session
        if ($user) {
            AuditService::logLogout($user, $request);
        }
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
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
        
        // Staff users go to staff dashboard
        if ($user->isStaff()) {
            return route('staff.dashboard');
        }
        
        // Super users go to main dashboard (can access all functions)
        if ($user->isSuperUser()) {
            return route('dashboard');
        }
        
        // All other users go to main dashboard
        return route('dashboard');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Only allow superusers and admins to access the main dashboard
        if (!$user->hasAdminPrivileges()) {
            // Redirect ID management users to their dashboard
            if ($user->isIdManagement()) {
                return redirect()->route('id-management.dashboard')
                    ->with('info', 'You have been redirected to your dedicated dashboard.');
            }
            
            // Redirect staff users to staff dashboard
            if ($user->isStaff()) {
                return redirect()->route('staff.dashboard')
                    ->with('info', 'You have been redirected to your staff dashboard.');
            }
            
            // Redirect other users to appropriate dashboard
            return redirect()->route('id-management.dashboard')
                ->with('info', 'You have been redirected to your dashboard.');
        }
        
        return view('dashboard', compact('user'));
    }

    /**
     * Update user email address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        
        // Only allow staff and admin users to update their email
        if (!$user->isStaff() && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Only staff and admin users can update their email address.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'email_confirmation' => 'required|email|same:email',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'email_confirmation.required' => 'Email confirmation is required.',
            'email_confirmation.same' => 'Email confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update the user's email
            $user->update([
                'email' => $request->email,
                'email_updated' => true,
                'last_modified_date' => now(),
                'last_modified_user' => $user->login_id,
            ]);

            // Log the email update
            AuditService::log(
                $user,
                'EMAIL_UPDATE',
                "Updated email address from {$user->getOriginal('email')} to {$request->email}",
                $user,
                ['email' => $user->getOriginal('email')],
                ['email' => $request->email],
                $request
            );

            return response()->json([
                'success' => true,
                'message' => 'Your email address has been updated successfully. You will not be prompted to update it again.',
                'data' => [
                    'email' => $user->email
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update email address. Please try again.'
            ], 500);
        }
    }
}
