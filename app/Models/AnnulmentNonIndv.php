<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnulmentNonIndv extends Model
{
    use HasFactory;

    protected $table = 'annulment_non_indv';

    protected $fillable = [
        'insolvency_no',              // No. Insolvensi
        'company_name',               // Nama Syarikat
        'company_registration_no',    // No. Pendaftaran Syarikat
        'others',                     // No. Lain
        'court_case_no',              // No. Kes Mahkamah
        'release_date',               // Tarikh Pelepasan
        'updated_date',               // Tarikh Kemaskini
        'release_type',               // Jenis Pelepasan
        'branch',                     // Nama Cawangan
        'is_active'                   // System field
    ];

    protected $casts = [
        'release_date' => 'date',
        'updated_date' => 'string', // Keep as string since it includes time
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

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
            if (empty($model->is_active)) {
                $model->is_active = true;
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
