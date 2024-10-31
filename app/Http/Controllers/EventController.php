<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;



class EventController extends Controller
{
    /*1-> Creamos una variable $validator en la que llamamos a la clase Illuminate\Support\Facades\Validator
    para utilizar su metodo estatico make
         •  $request->all(): Toma todos los datos enviados en la solicitud.
         •	Validamos que evento_name es obligatorio una cadena y tiene un max de 255 char
         •	Validamos que evento_detail es obligatorio una cadena y tiene un max de 255 char*/
    public function store (Request $request){
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'event_detail' => 'required|string|max:255',
            'event_type_id' => 'required|exists:event_types,id',
        ]);

    /*2-> Condicion-> si falla la validación   */
       if($validator->fails()){
           //devuelve un mensaje de error tipo 400 y termina el metodo
           return response()->json($validator->messages(), 400);
       }

    /*3-> Crea un evento en la base de datos usando el modelo Event y los datos de la solicitud.*/
       $event= Event::create([
           'event_name'=>$request->get('event_name'),
           'event_detail'=>$request->get('event_detail'),
           'event_type_id'=>$request->get('event_type_id'),
       ]);

    /*4-> Devuelve un mensaje de que el evento ha sido creado y la información del evento */
       return response()->json(['messages'=>'Event create', 'data'=>$event]);

    }

    public function listUsers(Event $event)
    {
        /*gracias a la relacion entre event y user guarda en la variable user los usuarios que esten relacionados
        con el evento que se pasa al metodo*/
        $user = $event->users;

        /*devuelve un mensaje con la informacion de los usuarios y el estado en 200 que significa que ha
         funcionado correctamente*/
        return response()->json(['message'=>null,'data'=>$user],200);
    }


}
