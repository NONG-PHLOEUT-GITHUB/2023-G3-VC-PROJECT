<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\GuardianResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ShowUserResource;
use App\Models\ClassRoom;
use App\Models\Comment;
use App\Models\Guardian;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json(['success' => true, 'data' => $user], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::store($request);
        return $user;
    }

    public function show(string $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Return the user as a resource
        return new ShowUserResource($user);
    }

    public function details(string $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Return the user as a resource
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::store($request, $id); 
        // return response()->json(['success' => true, 'message' => 'Update successfully','data'=>$user], 200);

        return $user;
    }

    /**
     * Remove the specified resource from storage.F
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        Classroom::where('coordinator_id', $id)->update(['coordinator_id' => null]);

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);
    }


    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!is_array($ids)) {
            return response()->json(['message' => 'Invalid request: IDs should be an array.'], 400);
        }

        // Retrieve users to be deleted
        $users = User::whereIn('id', $ids)->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No records found for the provided IDs.'], 404);
        }

        // Update related records
        Classroom::whereIn('coordinator_id', $ids)->update(['coordinator_id' => null]);

        // Delete users
        User::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Items deleted successfully'], 200);
    }

    public function getTotalByRoleAndGender()
    {
        $maleCounts = [];
        $femaleCounts = [];

        $roles = [1, 2, 3]; // Set the roles for which you want to get the data

        foreach ($roles as $roleId) {
            $maleCount = User::where('role', $roleId)->where('gender', 'male')->count();
            $femaleCount = User::where('role', $roleId)->where('gender', 'female')->count();

            $maleCounts[$roleId] = $maleCount;
            $femaleCounts[$roleId] = $femaleCount;
        }

        $results = [];
        foreach ($roles as $roleId) {
            $results[] = [
                'role' => $roleId,
                'total' => $maleCounts[$roleId] + $femaleCounts[$roleId],
                'male' => $maleCounts[$roleId],
                'female' => $femaleCounts[$roleId]
            ];
        }

        return response()->json(['success' => true, 'data' => $results], 200);
    }


    public function getStudent(Request $request)
    {
        $query = User::where('role', 3);

        // Define the filterable fields
        $filterableFields = ['first_name', 'last_name', 'email', 'phone_number', 'date_of_birth', 'address'];

        // Loop through the filterable fields and apply filters if values are provided
        foreach ($filterableFields as $field) {
            $query->when($request->filled($field), function ($q) use ($request, $field) {
                if ($field !== 'date_of_birth') {
                    // For string fields, perform a partial match using 'like'
                    $q->where($field, 'like', '%' . $request->input($field) . '%');
                } else {
                    // For 'date_of_birth', apply an exact match
                    $q->where($field, $request->input($field));
                }
            });
        }

        // Execute the query and return the filtered students
        $students = $query->orderBy('created_at', 'desc')->get();

        return response()->json(["message" => true, "data" => $students], 200);
    }


    public function getTeachers(Request $request)
    {
        $query = User::whereIn('role', [1, 2]);
        
        $filterableFields = ['first_name', 'last_name', 'email', 'phone_number', 'date_of_birth', 'address'];

        // Loop through the filterable fields and apply filters if values are provided
        foreach ($filterableFields as $field) {
            $query->when($request->filled($field), function ($q) use ($request, $field) {
                if ($field !== 'date_of_birth') {
                    // For string fields, perform a partial match using 'like'
                    $q->where($field, 'like', '%' . $request->input($field) . '%');
                } else {
                    // For 'date_of_birth', apply an exact match
                    $q->where($field, $request->input($field));
                }
            });
        }

        // Execute the query and return the filtered students
        $teachers = $query->orderBy('created_at', 'desc')->get();
        return response()->json(["message" => true, "data" => $teachers], 200);
    }

    public function getTeachersWithoutCoordinatorRole()
    {
        $teachersWithoutCoordinatorRole = User::where('role', 2)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('classrooms')
                    ->whereRaw('classrooms.coordinator_id = users.id');
            })
            ->get();

        return response()->json(["message" => true, "data" => $teachersWithoutCoordinatorRole], 200);
    }

    public function getTeacherBySubject($subject)
    {
        $users = User::where('role', 2)
            ->join('subject_teachers', 'users.id', '=', 'subject_teachers.teacher_id')
            ->join('subjects', 'subject_teachers.subject_id', '=', 'subjects.id')
            ->where('subjects.subject_name', '=', $subject)
            ->select('users.*')
            ->get();
        if ($users) {
            return response()->json(["message" => "No teacher with subject " . $subject], 404);
        }
        return response()->json(["message" => true, "data" => $users], 200);
    }


    /**
     * show total of student failed of each month.
     */
    public function getPercentageOfFaildedStudentByMonth()
    {

        $users = User::where('role', '=', 3)->get();

        $failed_users = collect();

        foreach ($users as $user) {
            $user_scores = Score::select('subject_id', 'score')
                ->where('user_id', '=', $user->id)
                ->get();

            $total_score = 0;
            foreach ($user_scores as $score) {
                $total_score += $score->score;
            }
            $average_score = $total_score / 14;

            if ($average_score < 25.00) {
                $failed_users->push($user);
            }
        }

        $total_users = $users->count();
        $failed_users_count = $failed_users->count();
        $failed_users_percentage = [($failed_users_count / $total_users) * 100];

        $failed_users_male_count = $failed_users->where('gender', '=', 'male')->count();
        $failed_users_female_count = $failed_users->where('gender', '=', 'female')->count();

        return response()->json([
            'total_users' => $total_users,
            'failed_users_count' => $failed_users_count,
            'failed_users_percentage' => $failed_users_percentage,
            'failed_users_male_count' => $failed_users_male_count,
            'failed_users_female_count' => $failed_users_female_count,
        ], 200);
    }


    // ----------------------get comment for student------------------------

    public function getCommentForStudent($user_id, $teacher_id)
    {
        $comments = Comment::where('user_id', $user_id)
            ->where('teacher_id', $teacher_id)
            ->get();
        $comment = CommentResource::collection($comments);
        return response()->json(['comments' => $comment]);
    }

    public function getUserIdFromGuardianId($id)
    {
        $user = User::where('id', $id)->first();
        $guardian = Guardian::all();
        $guardian = GuardianResource::collection($guardian);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json([
            'user_id' => $user->id,
            'guardian_id' => $user->guardian->chatId,
        ]);
    }

    public function getParentsByuser($id)
    {
        $user = User::where('id', $id)->first();
        $guardian = Guardian::all();
        $guardian = GuardianResource::collection($guardian);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json([
            'user_id' => $user->id,
            'guardian' => $user->guardian,
        ]);
    }

    public function getGuardianChatIdOfStudent($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if (!$user->guardian) {
            return response()->json(['error' => 'Guardian not found'], 404);
        }

        return response()->json([
            "id" => $user->guardian->id,
            'chat_id' => $user->guardian->chatId
        ]);
    }


    public function exportUsers()
    {
        $export = new ExportUser();
        return Excel::download($export, 'users.xlsx');
    }
}
