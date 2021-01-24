<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function store(Request $request, Group $group)
    {
        $user = Auth::user();

        // eventを作成
        $event = $group->events()->create([
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);

        // 場所を作成
        if ($place = $request->place) {
            $place = $event->places()->create([
                'event_id' => $event->id,
                'type' => $place['type'],
                'address' => $place['address'],
                'url' => $place['url'],
                'memo' => $place['memo'],
                'ranking' => $place['ranking'],
            ]);
            $event->place()->associate($place)->save();
        }
        if ($places = $request->places) {
            foreach ($places as $place) {
                $event->places()->create([
                    'type' => $place['type'],
                    'address' => $place['address'],
                    'url' => $place['url'],
                    'memo' => $place['memo'],
                    'ranking' => $place['ranking'],
                ]);
            }
        }

        // スケジュール作成
        if ($schedule = $request->schedule) {
            $schedule = $event->schedules()->create([
                'event_id' => $event->id,
                'datetime' => $schedule['datetime'],
                'ranking' => $schedule['ranking'],
            ]);
            $event->schedule()->associate($schedule)->save();
        }
        if ($schedules = $request->schedules) {
            foreach ($schedules as $schedule) {
                $event->schedules()->create([
                    'datetime' => $schedule['datetime'],
                    'ranking' => $schedule['ranking'],
                ]);
            }
        }

        // UserEventを作成
        $users = $request->users;
        $users[] = $user->id;
        $event->users()->attach($users);
    }
}
