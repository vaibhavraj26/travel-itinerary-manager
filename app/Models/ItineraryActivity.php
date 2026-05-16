<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryActivity extends Model
{
    protected $fillable = [
        'trip_id',
        'date',
        'start_time',
        'end_time',
        'title',
        'location',
        'notes',
        'type',
        'sort_order',
    ];

    /**
     * Get the trip that owns the activity.
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
