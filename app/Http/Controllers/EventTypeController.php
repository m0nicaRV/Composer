<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventTypeController extends Controller
{

    public function store (Request $request){
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);

        /*2-> Condicion-> si falla la validación   */
        if($validator->fails()){
            //devuelve un mensaje de error tipo 400 y termina el metodo
            return response()->json($validator->messages(), 400);
        }

        /*3-> Crea un evento en la base de datos usando el modelo Event y los datos de la solicitud.*/
        $eventType= EventType::create([
            'description'=>$request->get('description'),
        ]);

        /*4-> Devuelve un mensaje de que el evento ha sido creado y la información del evento */
        return response()->json(['messages'=>'EventType create', 'data'=>$eventType]);

    }
    public function listEvents(EventType $type){
        $events = $type->events;
        return response()->json(['message' =>null, 'data'=> $events], 200);

    }
}
