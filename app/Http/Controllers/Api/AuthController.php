<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        try{
            //checking if user exits
            $user = User::whereEmail($request->email)->firstOrFail();

            // checking provided password with hashed password
            if(Hash::check($request->password,$user->password)){
                // creating access token
                $token = $user->createToken('auth-token')->accessToken;
                return response()->json([
                    'user'=> $user,
                    'token'=>$token
                ],200);
            }else{
                // error of password doesn't match
                return response()->json([
                    'message'=> "Username or password is incorrect!",
                ],400);
            }
        }catch(Exception $ex){
            // throwing en error if anyhting goes wrong
            return response()->json([
                'message'=> "Something went wrong!",
            ],500);
        }
    }

    public function register(RegistrationRequest $request){
        try{
            // creating user account
            $user = User::create([
                "name"=>$request->name,
                "email"=>$request->email,
                "password"=>$request->password
            ]);
            // attaching role to the user
            $user->attachRole(2);
            if($user){
                // creating token to log user in right after registration
                $token = $user->createToken('auth-token')->accessToken;
                return response()->json([
                    'user'=> $user,
                    'token'=>$token
                ],200);
            }
        }catch(Exception $ex){
            // throwing en error if anyhting goes wrong
            return response()->json([
                'message'=> "Something went wrong!",
            ],500);
        }
    }

    public function user(){
        return auth()->user();
    }
}
