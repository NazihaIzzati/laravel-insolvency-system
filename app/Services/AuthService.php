<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Attempt to log the user in.
     *
     * @param array $credentials
     * @param bool $remember
     * @return User|null
     * @throws ValidationException
     */
    public function attemptLogin(array $credentials, bool $remember = false): ?User
    {
        $user = User::where('login_id', $credentials['staff_id'])->first();

        if (!$user) {
            return null;
        }

        // Check if user is active
        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'staff_id' => ['Your account has been deactivated. Please contact administrator.'],
            ]);
        }

        // Verify password
        if (!Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        // Login the user
        Auth::login($user, $remember);

        return $user;
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'user',
            'is_active' => true,
        ];

        return User::create($userData);
    }

    /**
     * Update user password.
     *
     * @param User $user
     * @param string $currentPassword
     * @param string $newPassword
     * @return bool
     * @throws ValidationException
     */
    public function updatePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        $user->update(['password' => $newPassword]);

        return true;
    }

    /**
     * Deactivate user account.
     *
     * @param User $user
     * @return bool
     */
    public function deactivateUser(User $user): bool
    {
        return $user->update(['is_active' => false]);
    }

    /**
     * Activate user account.
     *
     * @param User $user
     * @return bool
     */
    public function activateUser(User $user): bool
    {
        return $user->update(['is_active' => true]);
    }

    /**
     * Check if user can access admin area.
     *
     * @param User $user
     * @return bool
     */
    public function canAccessAdmin(User $user): bool
    {
        return $user->isAdmin() && $user->isActive();
    }
}
