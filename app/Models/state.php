<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class state extends Model
{
    protected $fillable = [
        'country_id',
        'name'
    ];

    public function country() 
    {
        return $this->belongsTo(Country::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(employee::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(city::class);
    }



}

