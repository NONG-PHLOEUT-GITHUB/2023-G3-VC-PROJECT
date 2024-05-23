<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'gender',
        'chat_id',
        'phone_number',
        'address',
        'profile',
        'date_of_birth',
        'age'
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public static function store($request, $id = null)
    {
        $guardians = $request->only(
            'id',
            'first_name',
            'last_name',
            'email',
            'gender',
            'chat_id',
            'phone_number',
            'address',
            'profile',
            'date_of_birth',
            'age'
        );

        if ($id) {
            $guardian = self::find($id);
            if (!$guardian) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $guardian->update($guardians);
        } else {
            $guardian = self::create($guardians);
            $id = $guardian->$id;
        }

        return response()->json(['success' => true, 'data' => $guardian], 201);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }

   
}
