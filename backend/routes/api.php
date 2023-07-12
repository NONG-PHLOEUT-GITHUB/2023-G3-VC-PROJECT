<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ClassRoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


Route::post('/login', 'LoginController@login');

// ***Route***
Route::resource("/users", UserController::class);
Route::resource("/attendances", AttendanceController::class);

Route::get("/getTotal", [UserController::class, "getTotalByRoleAndGender"]);
// ***Student***
Route::get("/getAttendance", [AttendanceController::class, "getAttendanceListOfStudents"]);
Route::get("/getMostAbsence", [AttendanceController::class, "getStudentMostAbsence"]);
Route::get("/getAttendance/{id}", [AttendanceController::class, "getAttendanceOfRole3ByUserId"]);
Route::get("/getStudentDetail/{id}", [AttendanceController::class, "showAttendanceDetail"]);
Route::get("/getTotalAbsentByMonth/{id}/{month}", [AttendanceController::class, "totalAbsentDaysByMonth"]);
Route::get("/getAverageAbsentAttendanceByMonth", [AttendanceController::class, "averageAbsentAttendanceByMonth"]);

// ***Teacher***
Route::get("/getTeacherAttendance", [AttendanceController::class, "getAttendanceListOfTeachers"]);
Route::get("/getTeacherMostAbsence", [AttendanceController::class, "getTeacherMostAbsence"]);
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class,"show"]);
Route::put('/users/{id}', [UserController::class,"update"]);
Route::resource('users' , UserController::class);
Route::get('/studentattendancedetail/{user_id}', [AttendanceController::class, 'showDetail']);
Route::post('/password/change', [ChangePasswordController::class,'change']);

Route::post('/sendPasswordResetLink', [ResetPasswordController::class, 'sendEmail']);
Route::get('/class_rooms/{id}', [ClassRoomController::class,"show"]);
Route::post('/class_rooms', [ClassRoomController::class,"store"]);

// Route::resource('attendance' , AttendanceController::class);

Route::post('/reset-password', [ForgotPasswordController::class,'resetPassword']);
Route::post('/forgot-password', [ForgotPasswordController::class,'forgotPassword']);

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
            // Change password user from application

        });
    });
});


