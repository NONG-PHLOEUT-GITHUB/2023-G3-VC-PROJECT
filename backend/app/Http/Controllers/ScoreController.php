<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scores = Score::all();
        return response()->json(['success' => true, 'data' => $scores], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $scores = Score::store($request);

        return response()->json(['success' => true, 'data' => $scores], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
    /**
     * get student score details.
     */
    public function getStudentScore(string $id, $month){

        $startDate = date('Y-m-01', strtotime($month));
        $endDate = date('Y-m-t', strtotime($month));

        $user_scores = Score::select('subjects.subject_name', 'scores.score', "month")
            ->join('users', 'scores.user_id', '=', 'users.id')
            ->join('subjects', 'scores.subject_id', '=', 'subjects.id')
            ->where('users.id', '=', $id)
            ->whereBetween('scores.month', [$startDate, $endDate])
            ->get();

        $total_score = 0;
        foreach ($user_scores as $score) {
            $total_score += $score->score;
        }
        $average_score = $total_score / 12;

        return response()->json([
            'user_id' => $id,
            'scores' => $user_scores,
            'total_score' => $total_score,
            'average_score' => $average_score,
        ], 200);
    }
    /**
     * get score of specific of student every month
     */
    public function getStudentScoreEveryMonth($userId){
        $averageScore = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = date('Y-m-01', strtotime(date('Y') . '-' . $month . '-01'));
            $endDate = date('Y-m-t', strtotime(date('Y') . '-' . $month . '-01'));
            $user_scores = Score::select('score')
                ->where('user_id', '=', $userId)
                ->whereBetween('month', [$startDate, $endDate])
                ->get();
            $total_score = 0;
            $num_scores = count($user_scores);
            foreach ($user_scores as $score) {
                $total_score += $score->score;
            }
            $average_score = ($num_scores > 0) ? $total_score / 12 : 0;
            $averageScore[date('F', mktime(0, 0, 0, $month, 1))] = $average_score;
        }
        return response()->json([
            'average_scores' => $averageScore,
        ], 200);
    }


    public function getStudentScoreByClass(string $classroomId)
    {
        // Find the classroom based on the classroom ID
        $classroom = Classroom::find($classroomId);

        if (!$classroom) {
            return response()->json(['error' => 'Classroom not found'], 404);
        }

           // Retrieve students (users) belonging to the classroom
        $students = $classroom->students;

        // Prepare an array to store formatted data
        $studentsWithScores = [];

        foreach ($students as $student) {
            // dd($student->scores);
        // Retrieve scores for each student
        // $scores = $student->scores;
        // / Retrieve scores for each student along with subject names
        $scores = Score::where('user_id', $student->id)
                       ->with('subject') // Eager load the 'subject' relationship
                       ->get();

        // Format the scores data for the student
        $formattedScores = $scores->map(function ($score) {
            return [
                'score_id' => $score->id,
                'subject' => $score->subject->name, // Access the subject name via the 'subject' relationship
                'score' => $score->score,
                // Add other attributes you want to include
            ];
        });

        // Add student data along with scores to the result array
        $studentsWithScores[] = [
            'student_id' => $student->id,
            'first_name' => $student->first_name, // Assuming 'name' is an attribute of the User model
            'last_name' => $student->last_name, // Assuming 'name' is an attribute of the User model
            'scores' => $formattedScores,
        ];
    }

    return response()->json(['success' => true, 'data' => $studentsWithScores], 200);

    }
}
