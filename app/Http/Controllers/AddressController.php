<?php

namespace App\Http\Controllers;


use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'country' => 'required|string|min:1|max:5',
            'zipcode' => 'required|string|min:5|max:6',
            //'user_id' => 'required|exists:users,id',
            'email'=> 'required|string|email|max:255|exists:users,email',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }
        $user=User::where('email',$request->get('email'))->firstOrFail();

        if($user->address){
            return response()->json(['message'=>'Already have an address','data'=>$user],400);
        }

        $address = Address::create([
            'country' => $request->get('country'),
            'zipcode' => $request->get('zipcode'),
            'user_id' => $user['id'],

        ]);
        return response()->json(['message'=>'Address create','data'=>$address],200);
    }

    public function show(Address $address){
        return response()->json(['message'=>'','data'=>$address],200);
    }
    public function show_user(Address $address)
    {

        return response()->json(['message'=>'','data'=>$address->user, ],200);

    }


    /*public function store(Request $request){
        $emailValidator = $this->validateEmail();
        $addressValidator= $this->validateAddres();

        if($emailValidator->fails() || $addressValidator->fails()){
            return response()->json(['message'=>'Failed',
            'email'=>$emailValidator->messages(),
            'address'=>$addressValidator->messages()], 400);
        }
        $user = User::where('email',$request->get('email'))->firstOrFail();

        if($user->address){
            return response()->json(['message'=>'Already have an address','data'=>$user],400);
        }

        $address = new Address($addressValidator->validated());

        if($user->address()->save($address)){
            return response()->json(['message'=>'Address saved','data'=>$address],200);
        }
        return response()->json(['message'=>'Failes','data'=>null],400);

    }

    public function validateEmail(){
        return Validator::make(request()->all(),[
            'email'=> 'required|string|email|max:255|exists:users,email'
        ]);


    }
    public function validateAddres(){
        return Validator::make(request()->all(),[
            'country' => 'required|string|min:1|max:5',
            'zipcode' => 'required|string|min:5|max:6',
        ]);
    }*/
}
