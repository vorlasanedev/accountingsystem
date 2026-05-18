<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Lot;
use App\Models\TransactionLot;
use App\Models\TransactionSplit;

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

    public function consumedLots()
    {
        return $this->belongsToMany(Lot::class, 'transaction_lots')
            ->withPivot('lak_consumed')
            ->withTimestamps();
    }

    protected static function booted()
    {
        static::updated(function (Transaction $transaction) {
            // Check if status changed to Approved and it wasn't approved before
            if ($transaction->isDirty('status') && $transaction->status === 'Approved') {
                DB::transaction(function () use ($transaction) {
                    $remainingAmountToCover = $transaction->total_amount;
                    $lotsToConsume = Lot::where('is_exhausted', false)
                        ->where('remaining_lak', '>', 0)
                        ->orderBy('date_requested', 'asc')
                        ->orderBy('id', 'asc')
                        ->lockForUpdate()
                        ->get();

                    $transactionLots = [];
                    $donorSplits = []; // To aggregate how much LAK each donor paid

                    foreach ($lotsToConsume as $lot) {
                        if ($remainingAmountToCover <= 0) break;

                        $consumeAmount = min($lot->remaining_lak, $remainingAmountToCover);
                        
                        $lot->remaining_lak -= $consumeAmount;
                        if ($lot->remaining_lak <= 0) {
                            $lot->is_exhausted = true;
                        }
                        $lot->save();

                        $transactionLots[] = [
                            'transaction_id' => $transaction->id,
                            'lot_id' => $lot->id,
                            'lak_consumed' => $consumeAmount,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        // Calculate the donor splits for this consumed portion
                        // Since a lot is comprised of multiple donors, the consumption is proportional to the lot's initial split.
                        $lotSplits = $lot->splits;
                        foreach ($lotSplits as $ls) {
                            // The ratio of this donor in the lot
                            $ratio = $ls->allocated_lak / $lot->total_lak;
                            $donorLak = $consumeAmount * $ratio;

                            if (!isset($donorSplits[$ls->fund_source_id])) {
                                $donorSplits[$ls->fund_source_id] = 0;
                            }
                            $donorSplits[$ls->fund_source_id] += $donorLak;
                        }

                        $remainingAmountToCover -= $consumeAmount;
                    }

                    if ($remainingAmountToCover > 0) {
                        throw new \Exception("Not enough funds in active lots to cover this transaction. Shortfall: " . $remainingAmountToCover . " LAK");
                    }

                    TransactionLot::insert($transactionLots);

                    $splitsToInsert = [];
                    foreach ($donorSplits as $fundSourceId => $amount) {
                        $splitsToInsert[] = [
                            'transaction_id' => $transaction->id,
                            'fund_source_id' => $fundSourceId,
                            'amount' => round($amount, 2),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    TransactionSplit::insert($splitsToInsert);
                });
            }
        });
    }
}
