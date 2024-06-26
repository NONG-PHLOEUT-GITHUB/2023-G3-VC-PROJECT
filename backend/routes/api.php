<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ImportExelFileController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SubjectController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ======================== Authentication Routes ==============

Route::prefix('auth')->group(function () {
    Route::post('/forgot-password', [ForgotPasswordController::class, 'send_reset_password_email']);
    Route::post('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword']);
    Route::post('/password/change', [ChangePasswordController::class, 'change']);
    Route::post('/sendPasswordResetLink', [ResetPasswordController::class, 'sendEmail']);
});

// ======================== Users Routes ========================

Route::prefix('users')->group(function () {
    Route::post('/import', [ImportExelFileController::class, 'import']);
    Route::get('/{id}/details', [UserController::class, 'details']);
    Route::get('/{id}/show', [UserController::class, 'show']);
    Route::put('/{id}/update', [UserController::class, 'update']);
    Route::post('/create-user', [UserController::class, 'store']);
    Route::get("/graph-student/fail", [UserController::class, "getPercentageOfFaildedStudentByMonth"]);
    Route::post('/getImage', [UserController::class, 'getImage']);
    Route::get("/subject/{subject}/teacher", [UserController::class, "getTeacherBySubject"]);
    Route::get('get/teachers', [UserController::class, "getTeachers"]);
    Route::delete('/teacher/{id}/delete-teacher', [UserController::class, "destroy"]);
    Route::get('get/students', [UserController::class, "getStudent"]);
    Route::delete('/student/{id}/delete', [UserController::class, "destroy"]);
    Route::get("get/total", [UserController::class, "getTotalByRoleAndGender"]);
    Route::get("/user/{id}", [UserController::class, "getUserIdFromGuardianId"]);
    Route::get("/parents/{id}", [UserController::class, "getParentsByuser"]);
    Route::get("/chat_id/{user_id}", [UserController::class, "getGuardianChatIdOfStudent"]);
    Route::get("/teacher/coordinator", [UserController::class, "getCoordinators"]);
    Route::get("/students/export-excel", [UserController::class, "exportUsers"]);
    Route::delete('/delete-multiple', [UserController::class, 'deleteMultiple']);
});

// ======================== Attendance Routes ========================

Route::prefix('attendances')->group(function () {
    Route::post("/", [AttendanceController::class, 'store']);
    Route::get("/get-attendance/students", [AttendanceController::class, "getAttendanceListOfStudents"]);
    Route::get("/students/get-most-absence", [AttendanceController::class, "getStudentMostAbsence"]);
    Route::get("/get-attendance/{id}/student", [AttendanceController::class, "getAttendanceOfRole3ByUserId"]);
    Route::get("/student/{id}/attendance-details", [AttendanceController::class, "showAttendanceDetail"]);
    Route::get("/getteacherDetail/{id}", [AttendanceController::class, "getAttendanceOfRole2ByUserId"]);
    Route::get("/student/attendanc/{userId}/monthly-attendance", [AttendanceController::class, "getTotalAttendanceOfSpecificStudentAllMonths"]);
    Route::post("/student/check-attendance", [AttendanceController::class, "store"]);
    Route::get("/getTotalAbsentByMonth/{id}/{month}", [AttendanceController::class, "totalAbsentDaysByMonth"]);
    Route::get("/getAbsentPercentageByMonth/{month}", [AttendanceController::class, "getAbsentPercentageByMonth"]);
    Route::get("/show-grahp-of-student-attendance", [AttendanceController::class, "getTotalAttendanceOfStudentsAllMonths"]);
    Route::get("/getTeacherAttendance", [AttendanceController::class, "getAttendanceListOfTeachers"]);
    Route::get("/getTeacherMostAbsence", [AttendanceController::class, "getTeacherMostAbsence"]);
    Route::get('/export-excel/{id}', [AttendanceController::class, "exportAttendance"]);
    Route::delete('/{id}/delete-attendance', [AttendanceController::class, "destroy"]);
});

// ======================== Classroom Routes ========================

Route::prefix('classrooms')->group(function () {
    Route::post("/", [ClassRoomController::class, 'store']);
    Route::get("/{classroom_id}/details", [ClassRoomController::class, 'getClassroomDetails']);
    Route::delete("/{id}/delete", [ClassRoomController::class, 'destroy']);
    Route::put("/{id}/update", [ClassRoomController::class, 'update']);
    Route::get("/{id}", [ClassRoomController::class, 'show']);
    Route::get("/", [ClassRoomController::class, 'index']);
    Route::get('/students/{class_id}/student-in-classroom', [ClassRoomController::class, 'getStudentsInClass']);
    Route::get('/total/get-classroom-total', [ClassRoomController::class, 'getTotalOfEachClass']);
    Route::get('/total/classroom-total', [ClassRoomController::class, 'countTotalClass']);
    Route::get('/student/{classroom_id}/attendance', [ClassRoomController::class, 'getStudentsAttendees']);
});

// ======================== Subject Routes ========================

Route::prefix('subjects')->group(function () {
    Route::get('/', [SubjectController::class, 'index']);
    Route::post('/', [SubjectController::class, 'store']);
});

// ======================== Comment Routes ========================

Route::prefix('comments')->group(function () {
    Route::get('/', [CommentController::class, 'index']);
    Route::post('/', [CommentController::class, 'store']);
    Route::put("/{id}/update", [CommentController::class, 'update']);
    Route::put("/{id}/delete", [CommentController::class, 'destroy']);
    Route::get("/student/{user_id}/{teacher_id}", [UserController::class, "getCommentForStudent"]);
});

// ======================== Score Routes ========================

Route::prefix('scores')->group(function () {
    Route::get('/', [ScoreController::class, 'index']);
    Route::post('/', [ScoreController::class, 'store']);
    Route::get('/student/{user_id}/monthly-score', [ScoreController::class, 'getStudentScoreEveryMonth']);
    Route::get('/student/{id}/{month}', [ScoreController::class, 'getStudentScore']);
    Route::post('/import-score', [ImportExelFileController::class, 'importExamResult']);
    Route::get('class/{id}', [ScoreController::class, 'getStudentScoreByClass']);
});

// ======================== Exam Routes ========================

Route::prefix('exams')->group(function () {
    Route::get('/', [ExamController::class, 'index']);
    Route::post('/', [ExamController::class, 'store']);
    Route::delete('/{id}/delete', [ExamController::class, 'destroy']);
    // Route::get('/student/{user_id}/monthly-score', [ExamController::class, 'getStudentScoreEveryMonth']);
    // Route::get('/student/{id}/{month}', [ExamController::class, 'getStudentScore']);
});

// ======================== Guardians Routes ========================

Route::prefix('guardians')->group(function () {
    Route::get("/{student_id}/chat-id", [GuardianController::class, "getGuardianChatId"]);
    Route::get("/", [GuardianController::class, "index"]);
    Route::get("/{id}/details", [GuardianController::class, "show"]);
    Route::post("/create-guardian", [GuardianController::class, "store"]);
    Route::put("/{id}/update", [GuardianController::class, "update"]);
    Route::delete("/{id}/delete", [GuardianController::class, "destroy"]);
    Route::delete('/delete-multiple', [GuardianController::class, 'deleteMultiple']);
    Route::get('/export-excel', [GuardianController::class, 'exportParentInformation']);
});

// ======================== API Authentication Routes ========================
Route::get('/token-expiry', [AuthController::class, 'getTokenExpiry']);

Route::prefix('v1/auth')->group(function () {
    // Login User
    Route::post('/login', [AuthController::class, "login"]);

    Route::middleware('auth:api')->group(function () {
        Route::get('/user', [AuthController::class, "user"]);
        // Logout user from application
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
