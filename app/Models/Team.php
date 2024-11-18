<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Team extends Model
{
    protected $fillable =['name','slug'];

    public  function employees(): HasMany 
    {
        return $this->hasMany(employee::class);
    }

    public  function departments(): HasMany 
    {
        return $this->hasMany(department::class);
    }

    //maybe add one more but this belongsToMany wokes not BelongsTo
    public function members(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }
    
}
