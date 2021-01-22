<?php

namespace App\Http\Controllers;

use App\Enums\ParticipantStatusType;
use App\Group;
use App\Participant;
use App\Services\Group\InvitationCodeGeneratorInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return $user
            ->participants()
            ->whereHas('group', function ($query) {
                $query->where('status', ParticipantStatusType::Accepted);
            })
            ->with('group')
            ->get();
    }

    public function store(Request $request, InvitationCodeGeneratorInterface $invitationCodeGenerator)
    {
        $group = Group::create([
            'created_by' => Auth::user()->id,
            'name' => $request->name,
            'invitation_code' => $invitationCodeGenerator->generate(),
        ]);
        Participant::create([
            'user_id' => Auth::user()->id,
            'group_id' => $group->id,
            'status' => ParticipantStatusType::Accepted,
        ]);
        return $group;
    }

    public function show(Group $group)
    {
        return $group;
    }

    public function update(Request $request, Group $group)
    {
        $group->fill($request->all())->save();
        return $group;
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return $group;
    }
}
