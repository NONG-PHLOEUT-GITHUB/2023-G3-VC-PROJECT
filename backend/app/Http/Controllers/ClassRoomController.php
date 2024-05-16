<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::all();
        $transformedClassrooms = ClassroomResource::collection($classrooms);

        return response()->json(['success' => true, 'data' => $transformedClassrooms], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $classroom = Classroom::store($request);
        return $classroom;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $classroom], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $classroom = Classroom::store($request, $id);
        return $classroom;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classroom = Classroom::find($id);

        if (!$classroom) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        $classroom->delete();

        return response()->json(['success' => true, 'message' => 'Classroom deleted successfully'], 200);
    }


    public function countTotalClass()
    {
        $totalClassroom = Classroom::count();
        return response()->json(['success' => true, 'data' => $totalClassroom], 200);
    }

    public function getStudentsInClass(string $classroomId)
    {
        // Retrieve the classroom by its ID
        $classroom = Classroom::findOrFail($classroomId);

        // Retrieve the students belonging to this classroom with role 3
        $students = $classroom->students;

        // Return response with the students belonging to the classroom
        return response()->json(['success' => true, 'data' => $students], 200);
    }

    public function getTotalOfEachClass()
    {
        $classroomCounts = [
            '10' => Classroom::where('classroom_name', 'like', '10%')->count(),
            '11' => Classroom::where('classroom_name', 'like', '11%')->count(),
            '12' => Classroom::where('classroom_name', 'like', '12%')->count(),
        ];

        return response()->json(['success' => true, 'data' => $classroomCounts], 200);
    }


    public function getClassroomDetails($classroomId)
    {

        $classroom = Classroom::with(['teachers' => function ($query) {
            $query->select('users.id', 'users.first_name', 'users.last_name', 'users.profile');
        }, 'teacherCoordinator' => function ($query) {
            $query->select('users.id', 'users.first_name', 'users.last_name', 'users.profile');
        }])->find($classroomId);

        // Accessing the data
        $teachers = $classroom->teachers;
        $coordinator = $classroom->teacherCoordinator;

        // Accessing the subjects taught by each teacher
        $teacherSubjects = [];
        foreach ($teachers as $teacher) {
            $teacherSubjects[$teacher->id] = $teacher->subjects;
        }


        return response()->json([
            'success' => true,
            'data' => [
                'classroom_name' => $classroom->classroom_name,
                'id' => $classroom->id,
                'teachers' => $teachers,
                'subject_teachers' => $teacherSubjects,
                'coordinator' => $coordinator
            ],
            'message' => 'Classroom data retrieved successfully'
        ], 200);
    }

    public function getStudentsAttendees($classroomId)
    {

        $classroom = Classroom::findOrFail($classroomId);
        $students = $classroom->students()->with('attendances')->select('id', 'profile', 'first_name', 'last_name')->get();

        // Return response with the students belonging to the classroom along with their attendances
        return response()->json(['success' => true, 'data' => $students], 200);
    }
}
