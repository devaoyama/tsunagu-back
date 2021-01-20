<?php

namespace App\Http\Controllers;

use App\Group;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function request(Request $request)
    {
        $group = Group::firstWhere([
            'invitation_code' => $request->invitation_code
        ]);
        $user = Auth::user();

        Participant::where([
            'group_id' => $group->id,
            'user_id' => $user->id,
        ])->firstOr(function () use ($user, $group) {
            return Participant::create([
                'group_id' => $group->id,
                'user_id' => $user->id,
            ]);
        });
    }

    public function leave(Group $group)
    {
        return Participant::where([
            'user_id' => Auth::user()->id,
            'group_id' => $group->id,
        ])->delete();
    }
}