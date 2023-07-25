<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'subject_id',
        'subject_name',
        'description',
        'schedule_id',
    ];




    public function teachers(){
        return $this->belongsToMany(User::class,'subject_teacher')->withTimestamps();
    }


    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
    public function score(){
        return $this->belongsTo(Score::class);
    }
}
