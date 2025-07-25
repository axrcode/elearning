<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    const ADMIN = 1;
    const TEACHER = 2;
    const STUDENT = 3;

    protected $fillable = [
        'name',
        'decription',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
