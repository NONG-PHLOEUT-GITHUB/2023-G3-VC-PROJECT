<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'body',
        'student_id',
        'teacher_id',
    ];
    public static function store($request, $id = null)
    {
        $comment = $request->only(
            'id',
            'body',
            'student_id',
            'teacher_id',
        );
        $comment = self::updateOrCreate(['id' => $id], $comment);
        
        return $comment;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}