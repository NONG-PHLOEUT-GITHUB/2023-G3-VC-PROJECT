<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'subject_name',
        'subject_code',
    ];

    public static function store($request, $id = null)
    {
        $subjects = $request->only(
            'id',
            'subject_name',
            'subject_code'
        );
        if ($id) {
            $subject = self::find($id);
            if (!$subject) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $subject->update($subjects);
        } else {
            $subject = self::create($subjects);
            $id = $subject->$id;
        }   
        return $subject;

        
    }

    public function teachers(){
        return $this->belongsToMany(User::class,'subject_teachers', 'subject_id', 'teacher_id')->withTimestamps();
    }
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
    public function score(){
        return $this->belongsTo(Score::class);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
