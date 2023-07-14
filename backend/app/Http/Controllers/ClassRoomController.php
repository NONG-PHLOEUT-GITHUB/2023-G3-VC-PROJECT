<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = ClassRoom::all();
        return response()->json(['success' => true, 'data' => $classrooms], 200);
    }
    /**
     * Display a listing of the resource.
     */
    // public function getClassStudents(Request $request)
    // {
    //     $role = $request->query(3);
    //     $class = $request->query('10A');

    //     $class = ClassRoom::where('class_name', $class)
    //         ->whereHas('user_id', function ($query) use ($role) {
    //             $query->where('role', $role);
    //         })
    //         ->get();

    //     return $class;
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $classrooms = ClassRoom::store($request);
        return response()->json(['success' => true, 'data' => $classrooms], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classroom = ClassRoom::find($id);
        if (empty($classroom)) {
            return response()->json(['success' => false, 'message' => 'Undefined classroom id:' . $id], 401);
        }
        return response()->json(['success' => true, 'data' => $classroom], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $classroom = ClassRoom::store($request, $id);
        return response()->json(['success' => true, 'message' => 'classroom update successfully', 'data' => $classroom], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classroom = ClassRoom::find($id);

        if (!$classroom) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        $classroom->delete();

        return response()->json(['success' => true, 'message' => 'classroom deleted successfully'], 200);
    }








    public function getClassNameUserId($user_id)
    {
   
        $user = User::find($user_id);

        if ($user === null) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $classroom = DB::table('class_rooms')
            ->join('users', 'users.id', '=', 'class_rooms.user_id')
            ->where('class_rooms.user_id', '=', 1)
            ->select('class_rooms.class_name', 'class_rooms.id')
            ->first();
        // return $classroom;
        if ($classroom === null) {
            return response()->json(['error' => 'Classroom not found'], 404);
        }

        $students = User::join('class_rooms', 'users.id', '=', 'class_rooms.user_id')
            ->where('class_rooms.id', $classroom->id)
            ->where('users.role', 3)
            ->select('users.first_name', 'users.last_name', 'users.email')
            ->get();
        
        return response()->json([
            'class_name' => $classroom->class_name,
            'students' => $students,
        ]);
    }
}
