<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function listEvents(User $user)
    {

        $events = $user->events;
        return response()->json(['message'=>null,'data'=>$events],200);
}

}
