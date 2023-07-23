<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ImportExelFileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SubjectTeacherController;
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

// ========================authentication router=========================================

Route::post('/forgot-password', [ForgotPasswordController::class,'send_reset_password_email']);
Route::post('/reset-new-password/{token}', [ForgotPasswordController::class,'resetPassword']);
Route::post('/password/change', [ChangePasswordController::class,'change']);
Route::post('/sendPasswordResetLink', [ResetPasswordController::class, 'sendEmail']);

// ========================users router==================================================

Route::post('/users_import', [ImportExelFileController::class, 'import']);
Route::get('/teacher_information/{teacher_id}',[UserController::class,'getTeacherDetail']);
Route::get('/users/{id}', [UserController::class,"show"]);
Route::put('/users/{id}', [UserController::class,"update"]);
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get("/getPercentageOfFaildedStudentByMonth/{year}", [UserController::class, "getPercentageOfFaildedStudentByMonth"]);
Route::post('/getImage', [UserController::class, 'getImage']);
Route::get("/users/subject/{subject}", [UserController::class, "getTeacherBySubject"]);
Route::get('/get-teachers', [UserController::class,"getTeachers"]);
Route::delete('/get-teachers/{id}', [UserController::class,"destroy"]);
Route::get('/get-students', [UserController::class,"getStudent"]);

// ========================attendance router=============================================

Route::post("/attendances", [AttendanceController::class, 'store']);
Route::resource("/attendances", AttendanceController::class);

// ========================classroom router==============================================

Route::post("/classrooms", [ClassRoomController::class, 'store']);
Route::delete("/classrooms/{id}", [ClassRoomController::class, 'destroy']);
Route::put("/classrooms/{id}", [ClassRoomController::class, 'update']);
Route::get("/classrooms/{id}", [ClassRoomController::class, 'show']);
Route::get("/classrooms", [ClassRoomController::class, 'index']);
Route::get('/classrooms', [ClassRoomController::class, 'index']);
// Route::get('/get_student', [ClassRoomController::class, 'getStudentInClassroom']);
Route::post('/classroom', [ClassRoomController::class, 'store']);
Route::get('/getClassStudents', [ClassRoomController::class, 'getClassStudents']);
Route::get('/class_rooms/{id}', [ClassRoomController::class,"show"]);
Route::delete('/getStudents/{id}', [UserController::class,"destroy"]);
Route::get('/getuserInClass/{class}', [ClassRoomController::class, 'getClassNameUserId']);

// ========================subject router===============================================

Route::get('/subjects', [SubjectController::class, 'index']);
Route::post('/subjects', [SubjectController::class, 'store']);

// ========================comment router==============================================

Route::get('/getComments', [CommentController::class, 'getComment']);
Route::post('/comments', [CommentController::class, 'store']);
Route::put("/comments", [CommentController::class, 'update']);
Route::get("/getcommentforspecificstudent/{id}", [UserController::class, "getCommentForStudent"]);

// ========================score router=============================================

Route::get('/scores', [ScoreController::class, 'index']);
Route::post('/scores', [ScoreController::class, 'store']);
Route::get('/getStudentScore/{id}/{month}', [ScoreController::class, 'getStudentScore']);

// ========================subject teachers router=================================== 

Route::get('/subjectsTeachers', [SubjectTeacherController::class, 'index']);
Route::post('/subjectsTeachers', [SubjectTeacherController::class, 'store']);

// ========================teachers router===========================================


// ========================Guardian router===========================================

Route::get("/getGuardian/{id}", [GuardianController::class,"getGuardianChatId"]);
Route::get("/getTotal", [UserController::class, "getTotalByRoleAndGender"]);

// ========================attendance router===========================================

Route::get("/getAttendance", [AttendanceController::class, "getAttendanceListOfStudents"]);
Route::get("/getMostAbsence", [AttendanceController::class, "getStudentMostAbsence"]);
Route::get("/getAttendance/{id}", [AttendanceController::class, "getAttendanceOfRole3ByUserId"]);
Route::get("/getStudentDetail/{id}", [AttendanceController::class, "showAttendanceDetail"]);
Route::get("/getteacherDetail/{id}", [AttendanceController::class, "getAttendanceOfRole2ByUserId"]);
Route::post("/checkStudentAttendance", [AttendanceController::class, "store"]);
Route::get("/getTotalAbsentByMonth/{id}/{month}", [AttendanceController::class, "totalAbsentDaysByMonth"]);
Route::get("/getAbsentPercentageByMonth/{month}", [AttendanceController::class, "getAbsentPercentageByMonth"]);
Route::get("/getTeacherAttendance", [AttendanceController::class, "getAttendanceListOfTeachers"]);
Route::get("/getTeacherMostAbsence", [AttendanceController::class, "getTeacherMostAbsence"]);
Route::get("/studentattendancedetail/{user_id}", [AttendanceController::class, "showDetail"]);

// ========================router=====================================================

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {

        // Login User
        Route::post('/login', [Authentication::class, "login"]);

        // Refresh the JWT Token
        // Route::get('/refresh', [AuthController::class, 'refresh']);

        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('/user', [Authentication::class,'user']);

            // Logout user from application
            Route::post('/logout',[Authentication::class,'logout']);
            // Change password user from application
        });
    });
});




