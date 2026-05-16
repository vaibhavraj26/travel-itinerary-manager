<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['trip_id', 'title', 'amount', 'category'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
