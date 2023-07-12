<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',
        'class_name',
        'teacher_id',
        'school_id',
    ];
    public static function store($request, $id = null)
    {
        $classRooms = $request->only(
            'class_id',
            'class_name',
            'teacher_id',
            'school_id',
        );
        if ($id) {
            $classRoom = self::find($id);
            if (!$classRooms) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $classRoom->update($classRooms);
        } else {
            $classRoom = self::create($classRooms);
            $id = $classRoom->$id;
        }
        return response()->json(['success' => true, 'data' => $classRoom], 201);
    }

    public function users(){
        return $this->hasMany(User::class);
    }


    public function schedule()
    {
        return $this->hasOne(User::class);
    }
}
