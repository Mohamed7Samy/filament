<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class city extends Model
{
    protected $fillable = [
        'state_id',
        'name'
    ];

    public function state() 
    {
        return $this->belongsTo(State::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(employee::class);
    }
}
