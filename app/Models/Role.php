<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];

    public const STAFF = 'Staff';
    public const SPV = 'SPV';
    public const MANAGER = 'Manager';
    public const DIRECTOR = 'Director';
    public const FINANCE = 'Finance';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}