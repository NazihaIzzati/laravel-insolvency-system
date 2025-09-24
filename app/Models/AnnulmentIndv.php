<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnulmentIndv extends Model
{
    use HasFactory;

    protected $table = 'annulment_indv';

    protected $fillable = [
        'annulment_indv_id',
        'no_involvency',
        'annulment_indv_position',
        'annulment_indv_branch',
        'name',
        'ic_no',
        'ic_no_2',
        'court_case_number',
        'ro_date',
        'ao_date',
        'updated_date',
        'branch_name',
        'email',
        'phone',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ro_date' => 'date',
        'ao_date' => 'date',
        'updated_date' => 'date',
    ];
}
