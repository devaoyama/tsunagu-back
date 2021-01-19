<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function group()
    {
        $this->belongsTo(Group::class);
    }
}
