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


    // public function getAllClassrooms()
    // {
    //     $classrooms = Classroom::withCount('students')
    //         ->select('classrooms.id', 'classrooms.classroom_name','classrooms.is_class_coordinator')
    //         ->with(['teachers.user'])
    //         ->get();
    //     $classroomCount = $classrooms->count();

    //     return response()->json(['success' => true, 'data' => $classrooms, 'count' => $classroomCount], 200);
    // }
    public function getAllClassrooms()
    {
        $classrooms = Classroom::with('teachers:id,first_name,last_name')
            ->select('classrooms.id', 'classrooms.classroom_name')
            ->get();

        $classroomCount = $classrooms->count();

        $transformedClassrooms = $classrooms->map(function ($classroom) {
            $classroom->is_class_coordinator = null;
            $classroom->first_name = $classroom->teachers->first()->first_name ?? null;
            $classroom->last_name = $classroom->teachers->first()->last_name ?? null;
            unset($classroom->teachers);
            return $classroom;
        });

        return response()->json(['success' => true, 'data' => $transformedClassrooms, 'count' => $classroomCount], 200);
    }

    // public function getAllClassrooms()
    // {
    //     $classrooms = Classroom::withCount('students')
    //         ->select('classrooms.id', 'classrooms.classroom_name', 'teachers.first_name as teacher_first_name', 'teachers.last_name as teacher_last_name')
    //         ->leftJoin('users as teachers', 'classrooms.teacher_id', '=', 'teachers.id') // Add the missing join condition
    //         ->where('teachers.role', 2)
    //         ->get();

    //     $classroomCount = $classrooms->count();

    //     return response()->json(['success' => true, 'data' => $classrooms, 'count' => $classroomCount], 200);
    // }


    public function countTotalClass()
    {
        $totalClassroom = Classroom::count();
        return response()->json(['success' => true, 'data' => $totalClassroom], 200);
    }


    public function getStudentsInClass(string $id)
    {
        // return $id;
        $classRooms = Classroom::where('id', $id)
            ->whereHas('students', function ($query) {
                $query->where('role', 3);
            })
            ->with([
                'students' => function ($query) {
                    // $query->withCount('attendances');
                    // $query->orderByDesc('role_attendances_count');
                    $query->with([
                        'scores' => function ($query) {
                            $query->orderBy('subject_id', 'asc');
                        }
                    ]);
                }
            ])
            ->get();

        if ($classRooms->isEmpty()) {
            return response()->json(['success' => false, 'data' => 'record not found'], 404);
        } else {
            return response()->json(['success' => true, 'data' => $classRooms], 200);
        }
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
}
