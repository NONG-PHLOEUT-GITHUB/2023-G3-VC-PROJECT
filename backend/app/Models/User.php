<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Mockery\Matcher\Subset;
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
        'password'
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
            'password'
        );
        $users['password'] = Hash::make($users['password']);

        if ($id) {
            $user = self::find($id);
            if (!$user) {
                return response()->json(['error' => 'Record not found'], 404);
            }
            $user->update($users);
        } else {
            $user = self::create($users);
            $id = $user->$id;
            
            // =============image====================
            if ($request->hasFile('profile')) {
                $profile = $request->file('profile');    
                // Generate a unique filename
                $filename = time() . '.' . $profile->getClientOriginalExtension();        
                {
                    // Store the file in the "src/assets" directory
                    $profile->storeAs('/public/', $filename);
                    // Update the user's profile image
                    $user->profile = $filename;
                    $user->save();
                } 
            }
        }
        
        // ==================upload image==================  
        // if($request->hash_file('profile')){
        //     $profile = $request->file('profile');
        //     $ext = $profile->extension();
        //     $file = time().'.'.$ext;
        //     $profile->storeAs('src/assets' , $file);
        //     $user->profile = $file;
        // }

        // ================token user password=================
        $token = null;
        $token = $user->createToken('TOKEN', ['select', 'create', 'update', 'delete']);
        return response()->json(['success' => true, 'data' => $user, 'token' => $token->plainTextToken], 201);
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
        return $this->belongsToMany(Subset::class, 'subject_teacher')->withTimestamps();
    }

    /**
     * user belongs to classroom
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
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