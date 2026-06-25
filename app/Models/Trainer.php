<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'specialization',
        'experience_years',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TrainerSchedule::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }


    public function getTotalTeachingHoursAttribute(): float
    {
        return $this->bookings()
            ->where('status', 1) // confirmed
            ->get()
            ->sum(function ($booking) {
                return (strtotime($booking->end_time) - strtotime($booking->start_time)) / 3600;
            });
    }
}
