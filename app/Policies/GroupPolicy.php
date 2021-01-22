<?php

namespace App\Policies;

use App\Enums\JoinStatusType;
use App\Group;
use App\User;
use App\UserGroup;
use Illuminate\Auth\Access\AuthorizationException;

class GroupPolicy
{
    public function store(User $user)
    {
        if ($user->groups()->count() > 1) {
            throw new AuthorizationException('グループは1つしか作成できません');
        }

        return true;
    }

    public function show(User $user, Group $group)
    {
        $userGroup = UserGroup::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'status' => JoinStatusType::Accepted,
        ]);
        if (!$userGroup) {
            throw new AuthorizationException('グループを取得する権限はありません');
        }

        return true;
    }

    public function update(User $user, Group $group)
    {
        $userGroup = UserGroup::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'status' => JoinStatusType::Accepted,
        ]);
        if (!$userGroup) {
            throw new AuthorizationException('グループを編集する権限はありません');
        }

        return true;
    }

    public function destroy(User $user, Group $group)
    {
        if ($group->created_by !== $user->id) {
            throw new AuthorizationException('グループを削除する権限はありません');
        }

        return true;
    }

    public function joinRequest(User $user, Group $group)
    {
        $userGroup = UserGroup::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id,
        ]);
        if ($userGroup) {
            return false;
        }

        return true;
    }

    public function joinAccept(User $user, Group $group, User $joinUser)
    {
        $userGroup = UserGroup::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'status' => JoinStatusType::Accepted,
        ]);
        if (!$userGroup) {
            throw new AuthorizationException('承認する権限はありません');
        }

        $userGroup = UserGroup::firstWhere([
            'user_id' => $joinUser->id,
            'group_id' => $group->id,
            'status' => JoinStatusType::Waiting
        ]);
        if (!$userGroup) {
            throw new AuthorizationException('このユーザーは承認できません');
        }

        return true;
    }

    public function joinReject(User $user, Group $group, User $joinUser)
    {
        $userGroup = UserGroup::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'status' => JoinStatusType::Accepted,
        ]);
        if (!$userGroup) {
            throw new AuthorizationException('拒否する権限はありません');
        }

        $userGroup = UserGroup::firstWhere([
            'user_id' => $joinUser->id,
            'group_id' => $group->id,
            'status' => JoinStatusType::Waiting
        ]);
        if (!$userGroup) {
            throw new AuthorizationException('このユーザーは拒否できません');
        }

        return true;
    }

    public function leave(User $user, Group $group)
    {
        $userGroup = UserGroup::firstWhere([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'status' => JoinStatusType::Accepted,
        ]);
        if (!$userGroup) {
            throw new AuthorizationException('グループを退会する権限はありません');
        }

        return true;
    }
}
