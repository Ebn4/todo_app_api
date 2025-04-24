<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8'
        ],[
            'email.required' => 'l\'email est obligatoire',
            'email.email' => 'l\'email n\'est pas valide',
            'email.unique' => 'l\'email est déjà utilisé'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $token = $user->createToken('api-token')->plainTextToken;
        $user['token'] = $token;

        return response()->json([
            "message" => "User was created",
            "user" => $user
        ], 200);


    }

    // la methede de connexion
    public function login(Request $request){
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                "message" => "Email ou mot de passe incorrecte"
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        $user['token'] = $token;

        return response()->json([
            "message" => "connexion reussi",
            "User" => $user,
        ]);
    }

    // La deconnexion
    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => "user has been logged out succesfully"
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "message" => $e->getMessage()
            ]);
        }
    }
}
