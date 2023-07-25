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
        $comments = $request->only(
            'id',
            'body',
            'user_id'
        );
        if ($id) {
            $comment = self::find($id);
            if (!$comment) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $comment->update($comments);
        } else {
            $comment = self::create($comments);
            $id = $comment->$id;
            }
        
        // ================token user password=================
        return response()->json(['success' => true, 'data' => $comment], 201);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
