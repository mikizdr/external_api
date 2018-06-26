<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Club extends Model
{
    /**
     * Illuminate\Database\Eloquent\Relations\BelongsToMany|Club
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
}
