<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Testing\Fluent\Concerns\Has;
use Carbon\Carbon;

class Booking extends Model
{
    public const CANCELLED = 0;
    public const CONFIRMED = 1;
    public const PENDING = 2;

    use HasFactory;
    protected $fillable = [
        'member_id',
        'trainer_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'cancellation_hours_before',
        'cancelled_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'cancelled_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function canBeCancelled(): bool
    {
        // Tạo datetime đầy đủ từ booking_date + start_time
        // Format booking_date as string to avoid double time specification
        $bookingDateTime = Carbon::parse($this->booking_date->format('Y-m-d') . ' ' . $this->start_time);
        $now = now();

        // Tính số giờ còn lại cho tới booking
        $hoursUntilBooking = $now->diffInHours($bookingDateTime, false);

        // Có thể hủy nếu còn lại >= số giờ yêu cầu
        return $hoursUntilBooking >= $this->cancellation_hours_before;
    }
}
