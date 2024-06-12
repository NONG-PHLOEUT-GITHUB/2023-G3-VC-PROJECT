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

        $authenticatedAt = Carbon::createFromTimestamp(auth()->user()->authenticated_at)->toDateTimeString();
        // dd($exam_id);
        $user = User::with([
            'attendances' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'teacherClassTeaching' => function ($query) use ($request) {
                $className = $request->input('className');
                $coordinatorName = $request->input('coordinatorName');
    
                // Apply className filter
                $query->when($className, function ($q) use ($className) {
                    $q->whereRaw("REPLACE(classroom_name, ' ', '') LIKE ?", ['%' . str_replace(' ', '', $className) . '%']);
                });
    
                // Apply coordinatorName filter
                $query->when($coordinatorName, function ($q) use ($coordinatorName) {
                    $q->whereHas('teacherCoordinator', function ($q) use ($coordinatorName) {
                        $q->where('first_name', 'like', '%' . $coordinatorName . '%')
                          ->orWhere('last_name', 'like', '%' . $coordinatorName . '%');
                    });
                });
            },
            'subjects',
            'scores' => function ($query) use ($request) {
                $exam_id = $request->input('exam_id');
                $query->join('subjects', 'scores.subject_id', '=', 'subjects.id')
                      ->select('scores.*', 'subjects.subject_code', 'subjects.subject_name as subject_name')
                      ->orderBy('scores.created_at', 'desc');
                if ($exam_id) {
                    $query->where('scores.exam_id', $exam_id);
                }
            },
            'coordinator',
            'exams',
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
