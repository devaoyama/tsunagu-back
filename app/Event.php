<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'comment',
    ];

    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'user_event')
            ->using(UserEvent::class)
            ->withPivot([
                'status',
                'comment',
            ])
            ->withTimestamps()
        ;
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
