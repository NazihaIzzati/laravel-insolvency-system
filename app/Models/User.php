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
        'password',
        'role',
        'is_active',
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
        'deleted_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * Set the user's password with hashing.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
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
}
