<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\SubmissionAttachment;

class Submission extends Model
{
    protected $fillable = [
        'submission_number',
        'submission_date',
        'user_id',
        'category_id',
        'amount',
        'description',
        'attachment',
        'status'
    ];

    protected $casts = [
        'submission_date'=>'date',
        'amount'=>'decimal:2'
    ];

    public const DRAFT = 'Draft';
public const SUBMITTED = 'Submitted';
public const WAITING_SPV = 'Waiting SPV Approval';
public const WAITING_MANAGER = 'Waiting Manager Approval';
public const WAITING_DIRECTOR = 'Waiting Director Approval';
public const WAITING_FINANCE = 'Waiting Finance';
public const PAID = 'Paid';
public const REJECTED = 'Rejected';

public const STATUSES = [
    self::DRAFT,
    self::SUBMITTED,
    self::WAITING_SPV,
    self::WAITING_MANAGER,
    self::WAITING_DIRECTOR,
    self::WAITING_FINANCE,
    self::PAID,
    self::REJECTED,
];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditTrails()
{
    return $this->hasMany(AuditTrail::class);
}
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function attachments()
{
    return $this->hasMany(
        SubmissionAttachment::class
    );
}
}