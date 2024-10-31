<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function(){
    Route::post('register', 'register');
    Route::get('user/{user}', 'show');
    Route::get('user/{user}/address', 'show_address');
    /*http://127.0.0.1:8000/api/users/{id user}/events/{id event}/book --> llama al evento bookEvent de
    la clase userController en el que relacionamos usuarios con eventos */
    Route::post('users/{user}/events/{event}/book', 'bookEvent');

    /*http://127.0.0.1:8000/api/users/{id user}/events--> Llama al metodo listEvents de UserController
    y lista los eventos que estan relacionados con el usuario */
    Route::get('user/{user}/events', 'listEvents');
});

Route::controller(AddressController::class)->group(function() {
    Route::post('address', 'store');
    Route::get('address/{address}', 'show');
    Route::get('address/{address}/user', 'show_user');
});

Route::controller(EventController::class)->group(function() {
    /*http://127.0.0.1:8000/api/event --> llama al evento store de
    la clase EventController en el creamos un eventos  */
    Route::post('event', 'store');

    /*    /*http://127.0.0.1:8000/api/event/{id evento}/users --> llama al evento listUser de
    la clase EventController y lista los usuarios que estan relacionados con evento  */
    Route::get('event/{event}/users', 'listUsers');
});
Route::controller(EventTypeController::class)->group(function() {
    Route::get('type/{type}', 'listEvents');
    Route::post('event/type', 'store');
});


