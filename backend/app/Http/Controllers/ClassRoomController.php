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
    public function index(Request $request)
    {
        $query = Classroom::query();
   
        $className = $request->input('className');
        $coordinatorName = $request->input('coordinatorName');

        $query->when($className, function ($q, $className) {
            $className = str_replace(' ', '', $className);
            return $q->whereRaw("REPLACE(classroom_name, ' ', '') LIKE ?", ['%' . $className . '%']);
        });

        $query->when($coordinatorName, function ($q, $coordinatorName) {
            return $q->whereHas('teacherCoordinator', function ($q) use ($coordinatorName) {
                $q->where('first_name', 'like', '%' . $coordinatorName . '%')
                ->orWhere('last_name', 'like', '%' . $coordinatorName . '%');
            });
        });

        $classrooms = $query->get();
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

    public function getStudentsInClass(Request $request,string $classroomId)
    {
        // Retrieve the classroom by its ID
        $classroom = Classroom::findOrFail($classroomId);

        $query = $classroom->students()->where('role', 3);

        // Define the filterable fields
        $filterableFields = ['first_name', 'last_name', 'gender', 'email','address'];

        // Loop through the filterable fields and apply filters if values are provided
        foreach ($filterableFields as $field) {
            $query->when($request->filled($field), function ($q) use ($request, $field) {
                $q->where($field, 'like', '%' . $request->input($field) . '%');
            });
        }

        // Execute the query to get the filtered students
        $students = $query->get();

        // Map through the students to include parent chat_id
        $studentsWithParentChatId = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'profile' => $student->profile,
                'gender' => $student->gender,
                'email' => $student->email,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'parent_chat_id' => $student->guardian->chat_id ?? null, // Assuming parent can be null
            ];
        });

        // Return response with the students belonging to the classroom
        return response()->json(['success' => true, 'data' => $studentsWithParentChatId], 200);
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
            $query->select('users.id', 'users.first_name', 'users.last_name', 'users.profile')
            ->with('subjects');
        }, 'teacherCoordinator' => function ($query) {
            $query->select('users.id', 'users.first_name', 'users.last_name', 'users.profile')->with('subjects');;
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
                'id' => $classroom->id,
                'classroom_name' => $classroom->classroom_name,
                'teachers' => $teachers,
                'subject_teachers' => $teacherSubjects,
                'coordinator_id' => $coordinator->id
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
