<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'trainer_id',
        'booking_date',
        'start_time',
        'end_time',
        'status'
    ];

    // Link back to the Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    // Link back to the Trainer (assuming you have a Trainer model, or User model)
    public function trainer()
    {
        // If your trainer data lives directly in the users table, change Member::class to User::class
        return $this->belongsTo(Member::class, 'trainer_id'); 
    }
}