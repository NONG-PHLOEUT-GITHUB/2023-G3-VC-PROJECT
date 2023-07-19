<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasMany(User::class);
    }
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'age',
        'date_of_birth',
        'phone_number',
        'address',
        'job',
    ];
    public static function store($request, $id = null)
    {
        $guardian = $request->only(
            'id',
            'first_name',
            'last_name',
            'gender',
            'age',
            'date_of_birth',
            'phone_number',
            'address',
            'job',
        );
        $guardian = self::updateOrCreate(['id' => $id], $guardian);

        return $guardian;
    }
}