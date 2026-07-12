<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'submission_id',
        'finance_id',
        'payment_date',
        'paid_amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'payment_date'=>'date',
        'paid_amount'=>'decimal:2'
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function finance(): BelongsTo
    {
        return $this->belongsTo(User::class,'finance_id');
    }
}