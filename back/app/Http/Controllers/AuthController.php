<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{
    public function login(Request $r){

        $validator = Validator::make($r->all(), [
            'email' => 'required',
            'password' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()
            ], 422);
        }
        $email = $r->email;
        $password = $r->password;
        $remember = $r->remember ? true : false;

        $intento = filter_var($email, FILTER_VALIDATE_EMAIL) ?
        ['email' => $email, 'password' => $password, 'active' => 1] :
        ['username' => $email, 'password' => $password, 'active' => 1];

        if (Auth::attempt($intento,$remember)) {
            $user = User::where('email',$email)->orWhere('username',$email)->firstOrFail();

            if($user){
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'success'=>true,
                    'message'=>'Logget in',
                    'results'=>[
                        'username'=>$user->username,
                        'email'=>$user->email,
                        'token'=>$token,
                        'id'=>$user->id
                    ]
                ]);

            }
        }


        return response()->json([
            'success'=>false,
            'Message'=>'Credentials are not valid'
        ],401);

    }


    public function check(){
        if(auth('sanctum')->check()){
            return response()->json([
                'results'=>[
                    'username'=>auth('sanctum')->user()->username,
                    'email'=>auth('sanctum')->user()->email,
                    'id'=>auth('sanctum')->user()->id
                ],
                'success'=>true,
                'message'=>'Valid',
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Token invalid',
            ]);
        }

    }

    public function user(Request $r){
        return response()->json([
            'success'=>true,
            'results'=> $r->user()
        ]);
    }

    public function register(Request $r){
        $validator = Validator::make($r->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()
            ], 422);
        }

        try {
            $newuser = User::create([
                'email'=>$r->email,
                'username'=>$r->username,
                'password'=>Hash::make($r->password),
                'name'=>$r->name,
                'active'=>1,
                'appversion'=>$r->appversion ?? 1
            ]);

            return response()->json([
                'success'=>true,
                'message'=>'User registered',
                'results'=> $newuser
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>'Server Error',
            ]);
            Log::debug($th);
        }
    }

    public function logout(Request $request){
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Token deleted',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>'Server Error',
            ]);
            Log::debug($th);
        }

    }

}

