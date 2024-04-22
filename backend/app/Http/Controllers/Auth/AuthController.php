<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login user and return a token
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
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
 
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

    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'success', 'access_token' => $token], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    
    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}
