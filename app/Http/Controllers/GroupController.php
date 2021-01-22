<?php

namespace App\Http\Controllers;

use App\Enums\JoinStatusType;
use App\Group;
use App\Http\Requests\JoinRequestGroupRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Services\Group\InvitationCodeGeneratorInterface;
use App\User;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return $user
            ->groups()
            ->wherePivot('status', JoinStatusType::Accepted)
            ->get()
        ;
    }

    public function store(StoreGroupRequest $request, InvitationCodeGeneratorInterface $invitationCodeGenerator)
    {
        $group = Group::create([
            'created_by' => Auth::user()->id,
            'name' => $request->name,
            'invitation_code' => $invitationCodeGenerator->generate(),
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->groups()->attach($group->id, [
            'status' => JoinStatusType::Accepted
        ]);
        return $group;
    }

    public function show(Group $group)
    {
        return $group;
    }

    public function update(UpdateGroupRequest $request, Group $group)
    {
        $group->fill($request->all())->save();
        return $group;
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return $group;
    }

    public function joinRequest(JoinRequestGroupRequest $request)
    {
        $group = Group::firstWhere([
            'invitation_code' => $request->invitation_code
        ]);
        if (!$group) {
            abort(400);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->groups()->attach($group->id);

        return $group;
    }

    public function joinAccept(User $user, Group $group)
    {
        return $user->groups()->updateExistingPivot($group->id, [
            'status' => JoinStatusType::Accepted,
        ]);
    }

    public function joinReject(User $user, Group $group)
    {
        return $user->groups()->updateExistingPivot($group->id, [
            'status' => JoinStatusType::Rejected,
        ]);
    }

    public function leave(Group $group)
    {
        /** @var User $user */
        $user = Auth::user();

        return $user->groups()->detach($group);
    }
}
