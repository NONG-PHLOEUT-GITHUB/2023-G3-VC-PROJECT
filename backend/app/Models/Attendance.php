<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'attendace_status',
        'reason',
        'date',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function store($request, $id = null)
    {
        $attendance = $request->only(
            'id', 
            'attendace_status',
            'reason',
            'date',
            'user_id'
        );
        $attendance = self::updateOrCreate(['id' => $id], $attendance);
        return $attendance;
    }
}
