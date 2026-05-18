<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionSplit extends Model
{
    protected $fillable = [
        'transaction_id',
        'fund_source_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function fundSource()
    {
        return $this->belongsTo(FundSource::class);
    }
}
