<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $credenTail = $request->only(
            'email',
            'password'
        );
        // dd(Auth::attempt($credenTail));

        if (Auth::attempt($credenTail)) {

            $user = Auth::user(); // get current user
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json(['login success' => true, 'data' => $user, 'token', $token], 201);
        }
        return response()->json(['message' => 'Invalid credentail'], 401);
    }
}
