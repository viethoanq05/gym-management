<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'memberships';

    protected $fillable = [
        'member_id',
        'package_id',
        'package_price',
        'start_date',
        'end_date',
        'status'
    ];

    // Link membership back to the member profile
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}