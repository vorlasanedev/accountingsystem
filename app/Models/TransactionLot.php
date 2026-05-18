<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionLot extends Model
{
    protected $fillable = [
        'transaction_id',
        'lot_id',
        'lak_consumed',
    ];

    protected $casts = [
        'lak_consumed' => 'decimal:2',
    ];
}
