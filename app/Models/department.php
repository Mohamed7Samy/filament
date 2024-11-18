<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class department extends Model
{
    protected $fillable = [
        'department_id',
        'name'
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(employee::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
