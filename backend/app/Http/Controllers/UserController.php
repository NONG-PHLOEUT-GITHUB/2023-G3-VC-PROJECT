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
        $user = User::find($id);
        if (empty($user)){
            return response()->json(['message' => "user id: " . $id . " doesn't exsit"], 404);
        }
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'age' => $request->input('age'),
            'date_of_birth' => $request->input('date_of_birth'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            // 'profile' => $request->input('profile'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
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
