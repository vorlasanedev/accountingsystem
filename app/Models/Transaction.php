<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = [
        'reference_number',
        'type',
        'account_id',
        'description',
        'total_amount',
        'status',
        'created_by',
        'approved_by',
        'locked_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'locked_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function splits()
    {
        return $this->hasMany(TransactionSplit::class);
    }

    protected static function booted()
    {
        static::saved(function (Transaction $transaction) {
            // Only split if not locked
            if ($transaction->locked_at) {
                return;
            }

            // In a real scenario, this might be queued or handled in an Action class.
            // For simplicity, we split automatically here.
            $fundSources = FundSource::where('is_active', true)->get();
            $totalPercentage = $fundSources->sum('allocation_percentage');

            // Clear existing splits if any
            $transaction->splits()->delete();

            if ($totalPercentage > 0) {
                $splitsToInsert = [];
                foreach ($fundSources as $source) {
                    $amount = ($transaction->total_amount * $source->allocation_percentage) / 100;
                    $splitsToInsert[] = [
                        'transaction_id' => $transaction->id,
                        'fund_source_id' => $source->id,
                        'amount' => round($amount, 2),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                TransactionSplit::insert($splitsToInsert);
            }
        });
    }
}
