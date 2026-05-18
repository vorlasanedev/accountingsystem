<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FundSource;

class Lot extends Model
{
    protected $fillable = [
        'reference_number',
        'description',
        'requested_usd',
        'exchange_rate',
        'total_lak',
        'remaining_lak',
        'date_requested',
        'is_exhausted',
    ];

    protected $casts = [
        'requested_usd' => 'decimal:2',
        'exchange_rate' => 'decimal:2',
        'total_lak' => 'decimal:2',
        'remaining_lak' => 'decimal:2',
        'date_requested' => 'date',
        'is_exhausted' => 'boolean',
    ];

    public function splits()
    {
        return $this->hasMany(LotSplit::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_lots')
            ->withPivot('lak_consumed')
            ->withTimestamps();
    }

    protected static function booted()
    {
        static::creating(function (Lot $lot) {
            $lot->total_lak = $lot->requested_usd * $lot->exchange_rate;
            $lot->remaining_lak = $lot->total_lak;
        });

        static::created(function (Lot $lot) {
            $fundSources = FundSource::where('is_active', true)->get();
            $splits = [];
            foreach ($fundSources as $source) {
                $usdAmount = ($lot->requested_usd * $source->allocation_percentage) / 100;
                $lakAmount = $usdAmount * $lot->exchange_rate;

                $splits[] = [
                    'lot_id' => $lot->id,
                    'fund_source_id' => $source->id,
                    'allocated_usd' => round($usdAmount, 2),
                    'allocated_lak' => round($lakAmount, 2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Update the available USD balance for the Fund Source (deduct the request)
                $source->available_usd_balance -= round($usdAmount, 2);
                $source->save();
            }
            LotSplit::insert($splits);
        });
    }
}
