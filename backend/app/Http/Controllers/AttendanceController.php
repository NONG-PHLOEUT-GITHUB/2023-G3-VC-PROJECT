<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
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
        //
        $attendance = Attendance::store($request);
        return $attendance;
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
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
    public function showAttendanceDetail($id)
    {
        $attendance = Attendance::findOrFail($id);

        return response()->json([
            'date' => $attendance->date,
            'reason' => $attendance->reason,
            'attendace_status' => $attendance->attendace_status,
        ]);
    }
    /**
     * show average of student attendance of each month.
     */
    public function averageAbsentAttendanceByMonth()
    {
        $absentAttendance = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
                            ->selectRaw('DATE_FORMAT(attendances.date, "%Y-%m") as month, COUNT(*) as absent_count')
                            ->where('attendances.attendace_status', '=', 'absent')
                            ->where('users.role', '=', 3)
                            ->groupBy('month')
                            ->get();
        
        $averageAbsentAttendanceByMonth = array();
        
        foreach ($absentAttendance as $attendance) {
            $averageAbsentAttendanceByMonth[$attendance->month] = $attendance->absent_count;
        }
        
        if (empty($averageAbsentAttendanceByMonth)) {
            return response()->json(['message' => "No reports found"], 404);
        }
        
        return response()->json(['averageAbsentAttendanceByMonth' => $averageAbsentAttendanceByMonth]);
    }
    public function totalAbsentDaysByMonth($user_id, $month)
    {
        $month = Carbon::createFromFormat('Y-m', $month);
        $absentAttendances = Attendance::where('user_id', $user_id)
            ->where('attendace_status', 'absent')
            ->whereMonth('date', $month->month)
            ->whereYear('date', $month->year)
            ->get();
    
        $totalAbsentDays = count($absentAttendances);

        if (empty($totalAbsentDays)) {
            return response()->json(['message' => "No absent this month"], 404);
        }
        return response()->json(['totalAbsentDays' => $totalAbsentDays]);
    }

}

