<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'event_id',
        'datetime',
        'ranking',
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
