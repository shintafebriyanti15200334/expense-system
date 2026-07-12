<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'=>'datetime',
            'password'=>'hashed'
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class,'approver_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class,'finance_id');
    }

    public function isStaff(): bool
    {
        return $this->role->name == Role::STAFF;
    }

    public function isSPV(): bool
    {
        return $this->role->name == Role::SPV;
    }

    public function isManager(): bool
    {
        return $this->role->name == Role::MANAGER;
    }

    public function isDirector(): bool
    {
        return $this->role->name == Role::DIRECTOR;
    }

    public function isFinance(): bool
    {
        return $this->role->name == Role::FINANCE;
    }

    public function auditTrails()
{
    return $this->hasMany(AuditTrail::class);
}
}