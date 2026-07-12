<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Approval extends Model
{
    protected $fillable = [
        'submission_id',
        'approver_id',
        'level',
        'status',
        'notes',
        'approved_at'
    ];

    protected $casts = [
        'approved_at'=>'datetime'
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class,'approver_id');
    }
}