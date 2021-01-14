<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return Group::all();
    }

    public function store(Request $request)
    {
        return Group::create($request->all());
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
