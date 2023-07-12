<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Message;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 400);
        }

        $response = Password::sendResetLink($request->only('email'));

        if ($response != Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'error',
                'message' => trans($response)
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => trans($response)
        ]);
    }




    // public function resetPassword(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'token' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6|confirmed'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()->all()
    //         ], 400);
    //     }

    //     $response = Password::reset($request->only(
    //         'email',
    //         'password',
    //         'password_confirmation',
    //         'token'
    //     ), function ($user, $password) {
    //         $user->password = bcrypt($password);
    //         $user->save();
    //     });

    //     if ($response != Password::PASSWORD_RESET) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => trans($response)
    //         ], 400);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => trans($response)
    //     ]);
    // }
}
