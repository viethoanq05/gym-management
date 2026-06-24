<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'dob',
        'height',
        'weight',
        'join_date',
    ];

    protected $casts = [
        'dob' => 'date',
        'join_date' => 'date',
        'height' => 'float',
        'weight' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
