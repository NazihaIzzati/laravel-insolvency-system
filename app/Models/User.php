<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_updated',
        'avatar',
        'login_id',
        'login_name',
        'password',
        'role',
        'officer_level',
        'branch_code',
        'is_active',
        'status',
        'expiry_date',
        'pwdchange_date',
        'last_modified_date',
        'last_modified_user',
        'password_reset_token',
        'password_reset_expires_at',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'email_updated' => 'boolean',
        'deleted_at' => 'datetime',
        'last_login_at' => 'datetime',
        'expiry_date' => 'date',
        'pwdchange_date' => 'datetime',
        'last_modified_date' => 'datetime',
        'password_reset_expires_at' => 'datetime',
    ];

    /**
     * Set the user's password with hashing.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        // Only hash if the value is not already hashed
        if (!empty($value) && !password_get_info($value)['algo']) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /**
     * Check if user is superuser.
     *
     * @return bool
     */
    public function isSuperUser()
    {
        return $this->role === 'superuser';
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is ID management.
     *
     * @return bool
     */
    public function isIdManagement()
    {
        return $this->role === 'id_management';
    }

    /**
     * Check if user is staff.
     *
     * @return bool
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Check if user has admin privileges (superuser or admin).
     *
     * @return bool
     */
    public function hasAdminPrivileges()
    {
        return in_array($this->role, ['superuser', 'admin']);
    }

    /**
     * Check if user is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get the user's role display name.
     *
     * @return string
     */
    public function getRoleDisplayAttribute()
    {
        return match($this->role) {
            'superuser' => 'Super User',
            'admin' => 'Administrator',
            'id_management' => 'ID Management',
            'staff' => 'Staff',
            default => 'Staff'
        };
    }

    /**
     * Get the user's status badge color.
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return $this->is_active ? 'green' : 'red';
    }

    /**
     * Get the user's status display name.
     *
     * @return string
     */
    public function getStatusDisplayAttribute()
    {
        return match($this->status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            'suspended' => 'Suspended',
            'expired' => 'Expired',
            default => ucfirst($this->status)
        };
    }

    /**
     * Check if user account is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if user needs password change.
     *
     * @return bool
     */
    public function needsPasswordChange()
    {
        if (!$this->pwdchange_date) {
            return true;
        }
        
        // Consider password change needed if older than 90 days
        return $this->pwdchange_date->diffInDays(now()) > 90;
    }

    /**
     * Check if user needs email update.
     * Only applies to staff and admin users.
     *
     * @return bool
     */
    public function needsEmailUpdate()
    {
        // Only staff and admin users need email updates
        if (!$this->isStaff() && !$this->isAdmin()) {
            return false;
        }
        
        return !$this->email_updated;
    }

    /**
     * Get the user's avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        // Generate a default avatar with initials
        $initials = strtoupper(substr($this->name, 0, 1));
        $color = $this->getAvatarColor();
        
        return "data:image/svg+xml;base64," . base64_encode("
            <svg width='40' height='40' xmlns='http://www.w3.org/2000/svg'>
                <rect width='40' height='40' fill='#{$color}' rx='20'/>
                <text x='20' y='26' font-family='Arial, sans-serif' font-size='16' font-weight='bold' text-anchor='middle' fill='white'>$initials</text>
            </svg>
        ");
    }
    
    /**
     * Get avatar color based on user name.
     *
     * @return string
     */
    private function getAvatarColor()
    {
        $colors = ['ef4444', '3b82f6', '10b981', 'f59e0b', '8b5cf6', 'ec4899', '6366f1', 'f97316'];
        $colorIndex = crc32($this->name) % count($colors);
        return $colors[$colorIndex];
    }

    /**
     * Update last modified information.
     *
     * @param string $modifiedBy
     * @return void
     */
    public function updateLastModified($modifiedBy)
    {
        $this->update([
            'last_modified_date' => now(),
            'last_modified_user' => $modifiedBy,
        ]);
    }

    /**
     * Generate a password reset token.
     *
     * @return string
     */
    public function generatePasswordResetToken()
    {
        $token = bin2hex(random_bytes(32));
        $this->update([
            'password_reset_token' => $token,
            'password_reset_expires_at' => now()->addHours(1), // Token expires in 1 hour
        ]);
        return $token;
    }

    /**
     * Check if password reset token is valid.
     *
     * @param string $token
     * @return bool
     */
    public function isValidPasswordResetToken($token)
    {
        return $this->password_reset_token === $token 
            && $this->password_reset_expires_at 
            && $this->password_reset_expires_at->isFuture();
    }

    /**
     * Clear password reset token.
     *
     * @return void
     */
    public function clearPasswordResetToken()
    {
        $this->update([
            'password_reset_token' => null,
            'password_reset_expires_at' => null,
        ]);
    }
}
