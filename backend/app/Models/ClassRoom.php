<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',
        'user_id',
        'class_name',
        
    ];
    public static function store($request, $id = null)
    {
        $class_rooms = $request->only(
            'class_id',
            'user_id',
            'class_name',
        );
        if ($id) {
            $class_room = self::find($id);
            if (!$class_rooms) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $class_room->update($class_rooms);
        } else {
            $user = self::create($class_rooms);
            $id = $user->$id;
        }
        return response()->json(['success' => true, 'data' => $class_room], 201);
    }

    public function users(){
        return $this->hasMany(User::class);
    }


    public function schedule()
    {
        return $this->hasOne(User::class);
    }
}
