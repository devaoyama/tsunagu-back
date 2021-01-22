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

    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'user_group')
            ->using(UserGroup::class)
            ->withPivot([
                'status',
            ])
        ;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
