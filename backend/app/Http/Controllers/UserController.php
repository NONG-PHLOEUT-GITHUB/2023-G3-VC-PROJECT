<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

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

    /**
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
        return response()->json(['success' => true, 'message' => 'user update successfully', 'user' => $user], 200);
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
}
