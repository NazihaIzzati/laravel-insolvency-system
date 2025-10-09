<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'url',
        'method',
        'metadata',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model that was affected.
     */
    public function model()
    {
        if ($this->model_type && $this->model_id) {
            return $this->model_type::find($this->model_id);
        }
        return null;
    }

    /**
     * Get formatted action display.
     */
    public function getActionDisplayAttribute(): string
    {
        return match($this->action) {
            'CREATE' => 'Created',
            'UPDATE' => 'Updated',
            'DELETE' => 'Deleted',
            'RESTORE' => 'Restored',
            'FORCE_DELETE' => 'Permanently Deleted',
            'LOGIN' => 'Logged In',
            'LOGOUT' => 'Logged Out',
            'PASSWORD_CHANGE' => 'Changed Password',
            'BULK_UPLOAD' => 'Bulk Upload',
            'BULK_DOWNLOAD' => 'Bulk Download',
            'SEARCH' => 'Searched',
            'VIEW' => 'Viewed',
            default => ucfirst(strtolower($this->action))
        };
    }

    /**
     * Get action color for display.
     */
    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'CREATE' => 'green',
            'UPDATE' => 'blue',
            'DELETE' => 'red',
            'RESTORE' => 'yellow',
            'FORCE_DELETE' => 'red',
            'LOGIN' => 'green',
            'LOGOUT' => 'gray',
            'PASSWORD_CHANGE' => 'orange',
            'BULK_UPLOAD' => 'purple',
            'BULK_DOWNLOAD' => 'indigo',
            'SEARCH' => 'cyan',
            'VIEW' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get action icon for display.
     */
    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'CREATE' => 'fas fa-plus',
            'UPDATE' => 'fas fa-edit',
            'DELETE' => 'fas fa-trash',
            'RESTORE' => 'fas fa-undo',
            'FORCE_DELETE' => 'fas fa-trash-alt',
            'LOGIN' => 'fas fa-sign-in-alt',
            'LOGOUT' => 'fas fa-sign-out-alt',
            'PASSWORD_CHANGE' => 'fas fa-key',
            'BULK_UPLOAD' => 'fas fa-upload',
            'BULK_DOWNLOAD' => 'fas fa-download',
            'SEARCH' => 'fas fa-search',
            'VIEW' => 'fas fa-eye',
            default => 'fas fa-circle'
        };
    }

    /**
     * Scope for filtering by user role.
     */
    public function scopeForRole($query, $role)
    {
        return $query->whereHas('user', function ($q) use ($role) {
            $q->where('role', $role);
        });
    }

    /**
     * Scope for filtering by action.
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for filtering by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}