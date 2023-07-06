<?php

<<<<<<< HEAD
use App\Http\Controllers\LoginController;
=======
use App\Http\Controllers\UserController;
>>>>>>> director_dashboard
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

<<<<<<< HEAD

Route::post('/login', 'LoginController@login');
=======
// ***Route User***
Route::resource("users", UserController::class);
// Route::post("/users", [UserController::class,'store']);

>>>>>>> director_dashboard
