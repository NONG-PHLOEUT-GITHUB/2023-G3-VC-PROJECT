<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'exam_name',
        'exam_code',
        'subject_id',
        'create_by'
    ];


    public static function store($request, $id = null)
    {
        $exams = $request->only(
            'id',
            'exam_name',
            'exam_code',
            'subject_id',
            'create_by'
        );
        
        if ($id) {
            $exam = self::find($id);
            if (!$exam) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $exam->update($exams);
        } else {
            $exam = self::create($exams);
            $id = $exam->$id;
        }

        // ================token user password=================
        return response()->json(['success' => true, 'data' => $exam], 201);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'exam_students', 'user_id', 'exam_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
