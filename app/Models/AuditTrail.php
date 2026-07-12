<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditTrail extends Model
{
    protected $fillable = [
        'user_id',
        'submission_id',
        'module',
        'action',
        'description',
        'ip_address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * User yang melakukan aktivitas
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Submission terkait
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }
}