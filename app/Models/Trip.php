<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'destination',
        'start_date',
        'end_date',
        'description',
        'status',
        'image_url',
    ];

    /**
     * Get the user that owns the trip.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activities for the trip.
     */
    public function activities()
    {
        return $this->hasMany(ItineraryActivity::class)->orderBy('date')->orderBy('start_time');
    }

    /**
     * Get the users that are shared on the trip.
     */
    public function sharedUsers()
    {
        return $this->belongsToMany(User::class)->withPivot('role', 'is_accepted')->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
