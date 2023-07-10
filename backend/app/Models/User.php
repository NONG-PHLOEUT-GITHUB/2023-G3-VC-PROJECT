<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
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
    public function role()
    {
        return $this->hasMany(Role::class, 'user_id');
    } 

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
    public static function store($request, $id = null)
    {
        $users = $request->only(
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
}
