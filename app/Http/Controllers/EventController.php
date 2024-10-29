<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Validator;



class EventController extends Controller
{
    public function store (Request $request){
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'event_detail' => 'required|string|max:255',
        ]);
       if($validator->fails()){
           return response()->json($validator->messages(), 400);
       }
       $event= Event::create([
           'event_name'=>$request->get('event_name'),
           'event_detail'=>$request->get('event_detail'),
       ]);
       return response()->json(['messages'=>'Event create', 'data'=>$event]);

    }

    public function listUsers(Event $event)
    {
        $user = $event->users;
        return response()->json(['message'=>null,'data'=>$user],200);
    }


}
