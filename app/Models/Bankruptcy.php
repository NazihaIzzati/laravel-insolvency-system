<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankruptcy extends Model
{
    use HasFactory;

    protected $fillable = [
        'insolvency_no',
        'name',
        'ic_no',
        'others',
        'court_case_no',
        'ro_date',
        'ao_date',
        'updated_date',
        'branch',
        'is_active'
    ];

    protected $casts = [
        'ro_date' => 'date',
        'ao_date' => 'date',
        'updated_date' => 'string', // Keep as string since it includes time
        'is_active' => 'boolean'
    ];

    /**
     * Boot method to automatically set updated_date
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->updated_date)) {
                $model->updated_date = now()->format('d/m/Y h:i A');
            }
        });

        static::updating(function ($model) {
            $model->updated_date = now()->format('d/m/Y h:i A');
        });
    }

    /**
     * Get formatted updated date
     */
    public function getFormattedUpdatedDateAttribute()
    {
        if (empty($this->updated_date)) {
            return 'N/A';
        }

        try {
            if (is_string($this->updated_date)) {
                return \Carbon\Carbon::createFromFormat('d/m/Y h:i A', $this->updated_date)->format('d/m/Y h:i A');
            } else {
                return $this->updated_date->format('d/m/Y h:i A');
            }
        } catch (\Exception $e) {
            return $this->updated_date; // Return as-is if parsing fails
        }
    }
}
