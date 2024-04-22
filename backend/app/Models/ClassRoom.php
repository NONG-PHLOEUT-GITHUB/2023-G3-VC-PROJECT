<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_name',
        'description',
        // 'is_class_coordinator',
        'teacher_id'
    ];

    public static function store($request, $id = null)
    {
        $classrooms = $request->only(
            'classroom_name',
            'description',
        );
        if ($id) {
            $classroom = self::find($id);
            if (!$classroom) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $classroom->update($classrooms);
        } else {
            $classroom = self::create($classrooms);
            $id = $classroom->$id;
        }
        // Sync the related teachers
        $teacherIds = $request->input('teacher_id', []);
        // $isClassCoordinator = $request->input('is_class_coordinator');
        if (empty($teacherIds)) {
            return response()->json(['error' => 'No teachers selected or class coordinator'], 400);
        }
        
        if (!$classroom->save()) {
            return response()->json(['error' => 'Error saving class room record'], 500);
        }
        $classroom->teachers()->sync($teacherIds);
        // $classroom->teachers()->sync($isClassCoordinator);

        return response()->json(['success' => true, 'data' => $classroom], 201);
    }


    // get by attributes
    protected $appends = ['student_count'];
    // protected $appends = ['is_class_coordinator'];

    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }

    // // one class have many teacher also one teacher has many classes
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'classroom_teachers', 'classroom_id', 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(User::class)->where('role', 3);
    }
}
