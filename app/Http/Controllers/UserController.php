<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
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
    public function show_address(User $user)
    {

        return response()->json(['message'=>'','data'=>$user->address, ],200);

    }

    public function bookEvent(Request $request, User $user, Event $event)
    {
        //hol
        //creamos la variable note y la inicializamos vacia
        $note = '';

        //Condicion -> comprueba si existe un campo note en los datos recibidos de la solicitud
        if($request->get('note')){
            //asigna el valor de note recibida en la solicitus en $note
            $note = $request->get('note');
        }

        /*Condicion -> si la operacion save es existosa -> guarda en evento en la relacion entre user
         y event y un array del campo $ note*/
        if($user->events()->save($event, array('note' => $note))){
            /*devuelve un mensaje de que el evento usurio se ha creado y devuelve la informacion de
            evento, user y note y se acaba el metodo*/
            return response()->json(['message'=>'User Event Created','data'=>array('evento'=>$event, 'Usuario'=>$user, 'note'=>$note)],200);
        }

        //devuelve un mensaje de error de estado 400 y se acaba el metodo
        return response()->json(['message'=>'Error','data'=>null],400);
    }

    public function listEvents(User $user)
    {
        //guarda en $event los eventos relacionados con el usuario que se ha recibido como parametro en la funcion
        $events = $user->events;

        //devuelve un mensaje con los datos de los eventos de codigo de estado 200
        return response()->json(['message'=>null,'data'=>$events],200);
    }


}
