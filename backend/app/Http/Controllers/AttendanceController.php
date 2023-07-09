<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $attendance = Attendance::store($request);

        return response()->json(['success' => true, 'data' => $attendance], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $attendance->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);
    }

    public static function getAttendanceByRole()
    {
        $roles = [1, 2, 3];
        $users = User::with([
            'roleAttendances' => function ($query) use ($roles) {
                $query->whereIn('user_id', function ($query) use ($roles) {
                    $query->select('id')
                        ->from('users')
                        ->whereIn('role', $roles);
                })
                ->select('user_id', 'date', 'attendace_status');
            }
        ])->get();
        $attendanceCount = [];
    
        foreach ($users as $user) {
            $attendance = [];
            $totalAttendance = 0;
            foreach ($user->roleAttendances as $attendanceItem) {
                $attendance[] = [
                    'date' => $attendanceItem->date,
                    'attendace_status' => $attendanceItem->attendace_status
                ];
                $totalAttendance++;
            }
            $role = $user->role;
            if (!isset($attendanceCount[$role])) {
                $attendanceCount[$role] = [
                    'attendance' => [],
                    'total_attendance' => 0
                ];
            }
            $attendanceCount[$role]['attendance'][] = [
                'user_id' => $user->id,
                'attendance' => $attendance
            ];
            $attendanceCount[$role]['total_attendance'] += $totalAttendance;
        }
    
        return $attendanceCount;
    }
}