<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_name',
        'coordinator_id',
        'teacher_id'
    ];

    public static function store($request, $id = null)
    {
        $classroomsData = $request->only(
            'classroom_name',
            'coordinator_id',
        );

        if ($id) {
            $classroom = self::find($id);
            if (!$classroom) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $classroom->update($classroomsData);
        } else {
            // Check if the classroom name already exists
            $existingClassroom = self::where('classroom_name', $classroomsData['classroom_name'])->first();

            if ($existingClassroom && $existingClassroom->id !== $id) {
                return response()->json(['error' => "classroom" ,'message'=>'Classroom name already exists'], 400);
            }
            $classroom = self::create($classroomsData);
            $id = $classroom->$id;
        }
        // // Sync the related teachers
        $teacherIds = $request->input('teacher_id', []);
        // dd($teacherIds);
        if (empty($teacherIds)) {
            return response()->json(['error' => 'Please select teacher'], 400);
        }

        if (!$classroom->save()) {
            return response()->json(['error' => 'Error saving class room record'], 500);
        }
        $classroom->teachers()->sync($teacherIds);

        return response()->json(['success' => true, 'data' => $classroom], 201);
    }


    // get by attributes
    protected $appends = ['student_count'];

    public function getTeacherFullNameAttributeInClassroom()
    {
        return $this->teachers->first_name . ' ' . $this->teachers->last_name;
    }

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

    ///one teacher have coodinator one 
    public function teacherCoordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }
}
