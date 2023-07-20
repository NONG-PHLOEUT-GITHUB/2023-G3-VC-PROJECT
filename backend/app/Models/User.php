<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'role',
        'first_name',
        'last_name',
        'gender',
        'age',
        'date_of_birth',
        'phone_number',
        'address',
        'profile',
        'email',
        'password',
        'class_room_id',
        'guardian_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }




    // model create 

    public static function store($request, $id = null)
    {
        $users = $request->only(
            'id',
            'role',
            'first_name',
            'last_name',
            'gender',
            'age',
            'date_of_birth',
            'phone_number',
            'address',
            'profile',
            'email',
            'password',
            'class_room_id',
            'guardian_id',
        );
        if ($id) {
            $user = self::find($id);
            if (!$user) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $user->update($users);
        } else {
            $user = self::create($users);
            $id = $user->$id;
            
            // // =============image====================
            // $image = $request->file('profile');
            // $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            // $image->move(public_path('images'),$new_name);
            // $path = asset('images/' . $new_name);
            // $user->profile= $path;
            // $user->save();
            }
        
        // ================token user password=================
        return response()->json(['success' => true, 'data' => $user], 201);
    }



    /**
     * user realationship with attendance
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    /**
     * user realationship with scores
     */

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    /**
     * user teacher realationship with subject 
     */

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher','user_id', 'subject_id')->withTimestamps();
    }

    /**
     * user belongs to classroom
     */
    public function classRooms()
    {
        return $this->belongsToMany(ClassRoom::class,'class_room_teacher', 'user_id', 'class_room_id');
    }

    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class,'class_room_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    /**
     * user belongs to parent
     */

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
    public function roleAttendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

}



