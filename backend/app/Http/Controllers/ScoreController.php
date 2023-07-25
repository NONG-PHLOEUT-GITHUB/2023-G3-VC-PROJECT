<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Score;
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
        $scores = Score::store($request);
        return response()->json(['success' => true, 'data' => $scores], 200);
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

        $user_scores = Score::select('subjects.subject_name', 'scores.score')
            ->join('users', 'scores.user_id', '=', 'users.id')
            ->join('subjects', 'scores.subject_id', '=', 'subjects.id')
            ->where('users.id', '=', $id)
            ->whereBetween('scores.month', [$startDate, $endDate])
            ->get();

        $total_score = 0;
        foreach ($user_scores as $score) {
            $total_score += $score->score;
        }
        $average_score = $total_score / 14;

        return response()->json([
            'user_id' => $id,
            'scores' => $user_scores,
            'total_score' => $total_score,
            'average_score' => $average_score,
        ], 200);
    }
}
