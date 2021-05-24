<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // return $request->all();
        // return response()->json(Auth::id());
        // if(Auth::user())
        //     return 'a';
        // else
            
        $user = User::where('email',$request->email)->first();
        
        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
            
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'roles' => $request->roles,
            ])){
            $request->session()->regenerate();
            return response()->json(Auth::user(), 200);
            // return $user->createToken($request->device_name)->plainTextToken;
            // return $user;
        } else {

            throw ValidationException::withMessages([
                'email' =>['The provided credentials are incorect.']
            ]);
        }
    }
    public function logout()
    {
        Auth::logout();
    }

    public function getUser() {
        return Auth::user();
    }
}