<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    public const EXPIRED = 0;
    public const ACTIVE = 1;
    public const WAITING_PAYMENT = 2;
    public const CANCELLED = 3;

    protected $fillable = [
        'member_id',
        'package_id',
        'package_price',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'package_price' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
