<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
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

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::store($request);

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $user = User::store($request, $id);

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.F
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);
    }

    // public function getTotalByRole()
    // {
    //     $totalByRole = [
    //         'director' => Role::where('role', 1)->count(),
    //         'teacher' => Role::where('role', 2)->count(),
    //         'student' => Role::where('role', 3)->count()
    //     ];
    //     return $totalByRole;
    // }
    public function getUerTotalByRoleAndGender()
    {
        $femaleUsers = User::where('gender', 'female')
            ->whereHas('roles', function ($query) {
                $query->where('role', 1);
            })
            ->get();
        return response()->json(['success' => true, 'data' => $femaleUsers], 200);
        // dd($femaleUsers);
    }
}