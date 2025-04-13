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
            'password_confirmation' => 'required'
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


        return response()->json([
            "message" => "L'utilisateur enreegistré avec succès",
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
            throw ValidationException::withMessages([
                'email' => ["Les informations incorrectes"]
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            "message" => "connexion reussi",
            "token" => $token,
            "User" => $user,
        ]);
    }
}
