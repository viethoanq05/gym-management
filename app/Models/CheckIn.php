<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckIn extends Model
{
    use HasFactory;

    // 1. Tell Laravel to use your exact table name (no underscore)
    protected $table = 'checkins';

    // 2. Allow mass assignment for your columns
    protected $fillable = [
        'member_id',
        'checkin_time',
        'checkout_time'
    ];

    // 3. Optional: treat these columns as real Carbon datetime objects
    protected $casts = [
        'checkin_time' => 'datetime',
        'checkout_time' => 'datetime',
    ];


    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
