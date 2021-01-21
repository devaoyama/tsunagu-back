<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'invitation_code',
    ];

    public function participants()
    {
        $this->hasMany(Participant::class);
    }
}
