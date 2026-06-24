<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // Tells Laravel to look up the users table using user_id
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}