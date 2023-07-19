<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guardian = Guardian::all();
        return response()->json(['success'=>true, 'data'=>$guardian], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $guardian = Guardian::store($request);
        return response()->json(['success'=>true, 'data'=>$guardian], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guardian = Guardian::find($id);
        return response()->json(['success'=>true, 'data'=>$guardian], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guardian = Guardian::store($request, $id);
        return response()->json(['success'=>true, 'data'=>$guardian], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guardian = Guardian::find($id);

        if (!$guardian) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }

        $guardian->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);
    }
}
