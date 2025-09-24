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
        'annulment_indv_position',
        'annulment_indv_branch',
        'name',
        'email',
        'phone',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
