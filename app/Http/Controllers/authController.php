<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class authController extends Controller
{
    public function register(Request $request){
        $fields=$request->validate([
           'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed',
        ]);
        $user=User::create([
           'name' => $fields['name'],
            'email'=> $fields['email'],
            'password'=> bcrypt($fields['password'])
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
    }
    public function login(Request $request){
        $fields=$request->validate([
            'name'=>'required|string',
            'email'=>'required|string:email',
            'password'=>'required|string',
        ]);
        $user = User::where('email',$fields['email'])->first();
//        check password
        if(!$user || !Hash::check($fields['password'],$user->password))
        {
            return Response([
                'message'=>'bad credits'
            ],401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
    }


    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message'=>'logout'
        ];

    }


}
