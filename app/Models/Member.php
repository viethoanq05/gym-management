<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Define which fields can be mass-assigned (matching your database columns)
    protected $fillable = [
        'user_id',
        'gender',
        'dob',
        'height',
        'weight',
        'join_date'
    ];

    /**
     * Get the user account associated with the member.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
