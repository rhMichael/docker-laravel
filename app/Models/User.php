<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    public function signinUser() {
        
    }

    public static function createUser(array $data)
    {
        // Create the user
        $user = self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Hash the password
        ]);

        // Return success message
        return $user ? 'User created successfully.' : 'Failed to create user.';
    }

    public static function loginUser(array $data)
    {
        $user = User::where('email', $data['email'])->first(); // Use first() to get a single user

    if ($user) {
        // Check if the password matches
        if (Hash::check($data['password'], $user->password)) {
            return $user; // Return the user object if the password matches
        } else {
            return null; // Password does not match
        }
    } else {
        return null; // User not found
    }
    }
}
