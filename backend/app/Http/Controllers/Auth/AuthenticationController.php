<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
     // https://jwt-auth.readthedocs.io/en/develop/laravel-installation/
    // https://jwt-auth.readthedocs.io/en/develop/quick-start/

    /**
     * Login user and return a token,'token'=>$token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = auth()->guard('api')->attempt($credentials)) {
            $user = auth()->user();
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'access_token' => $token,
            ], 200);
        }
        return response()->json(['error' => 'login_error'], 401);
    }


    /**
     * Logout User
     */

    public function logout()
    {
        auth()->user()->delete;
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Get authenticated user
     */

     public function user(Request $request)
    {
        if (auth()->check()) {
            $authenticatedAt = Carbon::createFromTimestamp(auth()->user()->authenticated_at)->toDateTimeString();

            $user = User::with([
                'attendances' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'classTeacher',
                'scores',
                'comments' => function ($query) {
                    $query->join('users', 'comments.teacher_id', '=', 'users.id')
                        ->select('comments.*', 'users.first_name', 'users.last_name', 'users.profile')
                        ->orderBy('comments.created_at', 'desc');
                }
            ])->find(auth()->user()->id);

            return response()->json([
                'status' => 'success',
                'authenticated_at' => $authenticatedAt,
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'User not authenticated',
        ], 401);
    }

    // public function user(Request $request)
    // {
     
    //     $user = User::with([
    //         'guardian',
    //         'attendances',
    //         'scores',
    //         'classTeacher',
    //         'comments' => function ($query) {
    //             $query->join('users', 'comments.teacher_id', '=', 'users.id')
    //             ->select('comments.*', 'users.first_name', 'users.last_name');
    //         }
    //     ])->find(Auth::user()->id);
        
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $user,
    //     ]);
    // }
}
