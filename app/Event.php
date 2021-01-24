<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'comment',
    ];

    public function schedule()
    {
        $this->belongsTo(Schedule::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
