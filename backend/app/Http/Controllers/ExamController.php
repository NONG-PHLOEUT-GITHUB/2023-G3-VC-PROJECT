<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamResource;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Exam::query();

        // Define the filterable fields
        $filterableFields = ['exam_name', 'exam_code', 'subject_name'];

        // Loop through the filterable fields and apply filters if values are provided
        foreach ($filterableFields as $field) {
            $query->when($request->filled($field), function ($q) use ($request, $field) {
                if ($field === 'subject_name') {
                    // If the field is 'subject_name', we need to join the subjects table
                    $q->whereHas('subject', function ($subjectQuery) use ($request, $field) {
                        $subjectQuery->where('subject_name', 'like', '%' . $request->input($field) . '%');
                    });
                } else {
                    $q->where($field, 'like', '%' . $request->input($field) . '%');
                }
            });
        }

        // Execute the query and get the filtered exams
        $exams = $query->get();

        // Transform the collection using ExamResource
        $exams = ExamResource::collection($exams);

        return response()->json([
            'status' => 'success',
            'data' => $exams
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exams = Exam::store($request);
        return $exams;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exam = Exam::find($id);
        $exam->delete();
        return response()->json(['success' => true, 'date' => "delete successfully"], 200);
    }
}
