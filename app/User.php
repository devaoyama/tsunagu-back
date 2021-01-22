<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'uid',
        'name',
        'picture_url',
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function createdGroups()
    {
        return $this->hasMany(Group::class);
    }
}
