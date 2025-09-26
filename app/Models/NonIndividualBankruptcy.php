<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonIndividualBankruptcy extends Model
{
    use HasFactory;

    protected $fillable = [
        'insolvency_no',
        'company_name',
        'company_registration_no',
        'others',
        'court_case_no',
        'date_of_winding_up_resolution',
        'updated_date',
        'branch',
        'is_active',
    ];

    protected $casts = [
        'date_of_winding_up_resolution' => 'date',
        'updated_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}