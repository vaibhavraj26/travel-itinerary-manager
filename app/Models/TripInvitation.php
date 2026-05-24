<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripInvitation extends Model
{
    protected $fillable = [
        'trip_id',
        'email',
        'role',
        'invited_by',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}
