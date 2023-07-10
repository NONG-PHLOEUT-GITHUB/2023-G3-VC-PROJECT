<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'attendance_status',
        'reason',
        'date',
        'teacher_id',
        'student_id',
        
    ];
    public static function store($request, $id = null)
    {
        $attendances = $request->only(
            'id',
            'attendance_status',
            'reason',
            'date',
            'teacher_id',
            'student_id',
        );

        if ($id) {
            $attendance = self::find($id);
            if (!$attendance) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $attendance->update($attendances);
        } else {
            $attendance = self::create($attendances);
            $id = $attendance->$id;
        }

        return response()->json(['success' => true, 'data' => $attendance], 201);
    }
}
