<?php

use App\Http\Controllers\Authentication;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class,"show"]);
Route::put('/users/{id}', [UserController::class,"update"]);
Route::resource('users' , UserController::class);



Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {

        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        // Route::post('/register', 'AuthController@register');
        // Route::post('/register', [LoginController::class, "register"]);

        // Login User
        Route::post('/login', [Authentication::class, "login"]);

        // Refresh the JWT Token
        // Route::get('/refresh', [AuthController::class, 'refresh']);

        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('/user', [Authentication::class,'user']);

            // Logout user from application
            Route::post('/logout',[Authentication::class,'logout']);
        });
    });
});
