<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundSource extends Model
{
    protected $fillable = [
        'name',
        'code',
        'donor_name',
        'allocation_percentage',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'allocation_percentage' => 'decimal:2',
    ];
}