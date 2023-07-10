<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class);
    }


    public function schedule()
    {
        return $this->hasOne(User::class);
    }
}
