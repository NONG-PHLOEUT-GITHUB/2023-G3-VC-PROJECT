<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

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
        'classroom_id',
        'guardian_id',
        'subject_id'
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
        // Check if the email already exists
        if ($request->has('email') && self::where('email', $request->input('email'))->exists()) {
            return response()->json(['error' => 'Email is already taken'], 422);
        }

        $requestData = $request->only(
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
            'classroom_id',
            'guardian_id',
        );
        if ($id) {
            $user = self::find($id);
            if (!$user) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            dd($user);
            $user->update($requestData);
        } else {

            // Validate the request for the profile image
            $request->validate([
                'profile' => 'required|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $image = $request->file('profile');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $path = asset('images/' . $new_name);
            $requestData['profile'] = $path;

            $password = Str::random(8);
            $requestData['password'] = bcrypt($password);

            $user = self::create($requestData);
            $id = $user->$id;

            // Send an email notification to the user
            Mail::send('email.new_user', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email, $user->first_name)->subject('Welcome to our system!');
            });
        }

        $sujectIds = $request->input('subject_id', []);
        $user->subjects()->sync($sujectIds);

        // ================token user password=================
        return response()->json(['success' => true, 'data' => $user], 201);
    }



    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_teachers', 'teacher_id', 'classroom_id');
    }

    // coordinator_id

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }
    /**
     * user realationship with scores
     */

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function teacherClassTeaching()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_teachers', 'teacher_id', 'classroom_id');
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }


    public function coordinator()
    {
        return $this->hasOne(Classroom::class, 'coordinator_id');
    }


    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teachers', 'teacher_id', 'subject_id');
    }
}
