<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'category_id',
        'budget_amount',
        'used_amount',
        'year'
    ];

    protected $casts = [
        'budget_amount'=>'decimal:2',
        'used_amount'=>'decimal:2'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRemainingBudgetAttribute()
    {
        return $this->budget_amount - $this->used_amount;
    }
}