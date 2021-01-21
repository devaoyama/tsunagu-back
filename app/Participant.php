<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function group()
    {
        $this->belongsTo(Group::class);
    }
}
