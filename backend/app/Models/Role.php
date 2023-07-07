<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'role',
        'user_id',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'id');
    } 
    public static function store($request, $id = null)
    {
        $role = $request->only(
            'role',
            'user_id',
        );
        $role = self::updateOrCreate(['id' => $id], $role);
        return $role;
    }
}
