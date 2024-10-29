<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        return response()->json(['message'=>'User Created','data'=>$user],200);
    }

    public function show(User $user)
    {
        return response()->json(['message'=>'','data'=>$user],200);
    }

    public function bookEvent(Request $request, User $user, Event $event)
    {
        $note = '';
        if($request->get('note')){
            $note = $request->get('note');
        }
        if($user->events()->save($event, array('note' => $note))){
            return response()->json(['message'=>'User Event Created','data'=>$event],200);
        }
        return response()->json(['message'=>'Error','data'=>null],400);
    }

    public function listEvents(User $user)
    {
        $events = $user->events;
        return response()->json(['message'=>null,'data'=>$events],200);
    }


}
