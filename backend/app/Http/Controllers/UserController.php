<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json(['success'=>true, 'data'=>$user], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::store($request);
        return $user;
    }


    public function getImage(StoreUserRequest $request)
    {

        $image = $request->file('profile');
        $new_name =  rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'),$new_name);
        $path = asset('images/' . $new_name);
        return $path;

    }    /**
     * Display the specified resource.
     */
    public function getEmails($id)
    {
        return User::select('email')->where('id','!=', $id)->where('role', '!=', 'admin')->get();
    }
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, string $id)
    {
        $user = User::store($request,$id);
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

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);
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

    
    public function getStudent()
    {
        $users = User::where('role', 3)
            ->select('id', 'first_name', 'last_name','gender','age','date_of_birth','phone_number','address','email', 'profile')
            ->get();
        return response()->json($users);
    }
    public function getTeachers()
    {
        $users = User::where('role', 2)
            ->select('id', 'first_name', 'last_name','gender','age','date_of_birth','phone_number','address','email', 'profile')
            ->get();
        return response()->json($users);
    }
    public function getStudentId($id){
        $user = User::find($id);
        return response()->json($user);
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
            return response()->json(["message" =>  "No teacher with subject " . $subject], 404);
        }
        return response()->json(["message" => true, "data" => $users], 200);
    }
    
    
    // --------------------------------Teacher Detail--------------------------------
    
    // public function getTeacherDetail($teacher_id){
    //     $teacher = User::where('role', 2)
    //         ->join('class_room_teacher', 'users.id', '=', 'class_room_teacher.user_id')
    //         ->join('class_rooms', 'class_room_teacher.class_room_id', '=', 'class_rooms.id')
    //         ->where('users.id', $teacher_id)
    //         ->get(['class_rooms.*']);
    
    //     return response()->json(["message" => true, "data" => $teacher], 200);
    // }
}