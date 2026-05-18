<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotSplit extends Model
{
    protected $fillable = [
        'lot_id',
        'fund_source_id',
        'allocated_usd',
        'allocated_lak',
    ];

    protected $casts = [
        'allocated_usd' => 'decimal:2',
        'allocated_lak' => 'decimal:2',
    ];

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function fundSource()
    {
        return $this->belongsTo(FundSource::class);
    }
}
