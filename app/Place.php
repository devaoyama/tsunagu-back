<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'event_id',
        'type',
        'address',
        'url',
        'memo',
        'ranking',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
