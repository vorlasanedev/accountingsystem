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
        'initial_usd_balance',
        'available_usd_balance',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'allocation_percentage' => 'decimal:2',
        'initial_usd_balance' => 'decimal:2',
        'available_usd_balance' => 'decimal:2',
    ];

    public function lotSplits()
    {
        return $this->hasMany(LotSplit::class);
    }

    public function transactionSplits()
    {
        return $this->hasMany(TransactionSplit::class);
    }

    public function getSpentLakAttribute()
    {
        return $this->transactionSplits()->sum('amount');
    }

    public function getSpentUsdAttribute()
    {
        $totalUsd = 0;
        $transactionIds = $this->transactionSplits()->pluck('transaction_id');
        
        foreach ($transactionIds as $txId) {
            $txLots = TransactionLot::where('transaction_id', $txId)->get();
            foreach ($txLots as $tl) {
                $lot = Lot::find($tl->lot_id);
                if (!$lot) continue;
                
                $split = LotSplit::where('lot_id', $lot->id)->where('fund_source_id', $this->id)->first();
                if ($split) {
                    $ratio = $split->allocated_lak / $lot->total_lak;
                    $lakPortion = $tl->lak_consumed * $ratio;
                    $usdPortion = $lakPortion / $lot->exchange_rate;
                    $totalUsd += $usdPortion;
                }
            }
        }
        return round($totalUsd, 2);
    }
}