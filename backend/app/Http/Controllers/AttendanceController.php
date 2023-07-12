<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = Attendance::all();
        return response()->json(['success' => true, 'data' => $attendance], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {
        $attendance = Attendance::store($request);
        return response()->json(['success' => true, 'data' => $attendance], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $attendance], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
        $attendance = Attendance::store($request, $id);
        return response()->json(['success' => true, 'data' => $attendance], 200);
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'Attendance not found'], 404);
        }
        $attendance->delete();
        return response()->json(['success' => true, 'message' => 'Attendance deleted successfully'], 200);
    }
    /**
     * Get attendance list of students.
     */
    public static function getAttendanceListOfStudents()
    {
        $users = User::where('role', 3)
            ->select('id', 'first_name', 'last_name')
            ->withCount('roleAttendances')
            ->get();
        return response()->json($users);
    }
    /**
     * Get five students that most absence.
     */
    public static function getStudentMostAbsence()
    {
        $users = User::where('role', 3)
            ->select('id', 'first_name', 'last_name')
            ->withCount('roleAttendances')
            ->orderByDesc('role_attendances_count')
            ->limit(5)
            ->get();
        return response()->json($users);
    }
    /**
     * Get attendance list of teachers.
     */
    public static function getAttendanceListOfTeachers()
    {
        $users = User::where('role', 2)
            ->select('id', 'first_name', 'last_name')
            ->withCount('roleAttendances')
            ->get();
        return response()->json($users);
    }
    /**
     * Get five teacher that most absence.
     */
    public static function getTeacherMostAbsence()
    {
        $users = User::where('role', 2)
            ->select('id', 'first_name', 'last_name')
            ->withCount('roleAttendances')
            ->orderByDesc('role_attendances_count')
            ->limit(5)
            ->get();
        return response()->json($users);
    }
    /**
     * show attendance of student detail .
     */
    public static function getAttendanceOfRole3ByUserId($id)
    {
        $user = User::where('role', 3)
            ->find($id);

        if ($user) {
            $attendanceRecords = $user->roleAttendances;
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                ],
                'attendanceRecords' => $attendanceRecords,
            ]);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}