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
        'updated_date' => 'date',
        'is_active' => 'boolean'
    ];
}
