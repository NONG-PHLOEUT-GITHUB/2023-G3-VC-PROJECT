<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $credentials  = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if(Auth::attempt($credentials)){
            return response()->json(['status' => true, 'message' => 'Login successful']);
        }

        return response()->json(['status' => false, 'message' => 'failed']);
    }
}
