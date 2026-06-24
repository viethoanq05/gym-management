<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainerSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'work_date',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'work_date' => 'date',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }
}
