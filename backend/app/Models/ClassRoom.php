<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_name',
        'description',
        
    ];
    public static function store($request, $id = null)
    {
        $classRooms = $request->only(
            'class_name',
            'description',
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

    public function teachers(){
        return $this->belongsToMany(User::class,'class_room_teacher', 'user_id', 'class_room_id');
    }


    public function schedule()
    {
        return $this->hasOne(User::class);
    }
}
