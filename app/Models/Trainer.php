<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'specialization',
        'experience_years',
    ];

    /**
     * Trainer thuộc về 1 user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
