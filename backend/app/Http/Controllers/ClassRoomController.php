<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $class = $request->query('class_name');

        if ($class) {
            $students = ClassRoom::where('class_name', $class)->get();
        } else {
            $students = ClassRoom::all();
        }

        return $students;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = ClassRoom::store($request);
        return $user;
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
        $classroom = ClassRoom::store($request,$id);
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

    public function getClassStudent()
    {
        $users = User::where('role', 3)
            ->select('id', 'first_name', 'last_name','gender','age','date_of_birth','phone_number','address','email')
            ->get();
        return response()->json($users);
    }
}
