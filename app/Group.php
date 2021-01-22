<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'created_by',
        'name',
        'invitation_code',
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
