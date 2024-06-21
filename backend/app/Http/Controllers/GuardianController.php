<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Guardian;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\ExportParent;
use Maatwebsite\Excel\Facades\Excel;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guardian::query();

         // Define the filterable fields
        $filterableFields = ['first_name', 'last_name', 'chat_id', 'phone_number', 'date_of_birth'];

        // Loop through the filterable fields and apply filters if values are provided
        foreach ($filterableFields as $field) {
            if ($request->filled($field)) {
                // For string fields, perform a partial match using 'like'
                if ($field !== 'date_of_birth') {
                    $query->where($field, 'like', '%' . $request->input($field) . '%');
                } else {
                    // For 'date_of_birth', apply an exact match
                    $query->where($field, $request->input($field));
                }
            }
        }

        // Execute the query and return the filtered guardians
        $guardians = $query->orderBy('created_at', 'desc')->get();
    
        // Return the filtered guardians as JSON response
        return response()->json(['success' => true, 'data' => $guardians], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $guardian = Guardian::store($request);
        return $guardian;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guardian = Guardian::find($id);

        if (!$guardian) {
            return response()->json(['message' => 'The record with ID ' . $id . ' was not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $guardian], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,string $id)
    {
        $guardian = Guardian::store($request ,$id);
        return $guardian;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guardian = Guardian::find($id);
        User::where('guardian_id', $id)->update(['guardian_id' => null]);
        $guardian->delete();
        return response()->json(['success' => true, 'data' => "delete successfully"], 200);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');
        // dd($ids);
        if (is_array($ids)) {
            Guardian::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Items deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid request'], 400);
        }
    }

    public function getGuardianChatId($id)
    {
        $guardian = Guardian::find($id);
        if (!$guardian) {
            return response()->json(['error' => 'Guardian not found'], 404);
        }
        return response()->json([
            "id" => $guardian->id,
            'chat_id' => $guardian->chatId
        ]);
    }




    public function getGuardianChatIdOfStudent($id)
    {
        $guardian = Guardian::find($id);
        if (!$guardian) {
            return response()->json(['error' => 'Guardian not found'], 404);
        }
        return response()->json([
            "id" => $guardian->id,
            'chat_id' => $guardian->chatId
        ]);
    }

    public function exportParentInformation()
    {
        $export = new ExportParent();
        return Excel::download($export, 'users.xlsx');
    }
}
