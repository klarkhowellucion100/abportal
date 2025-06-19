<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partner_registrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Casts the 'password' field to a hashed value
        'password' => 'hashed',
    ];

    /**
     * Set the password attribute for the user.
     * This mutator hashes the password before saving it.
     *
     * @param string $value
     */
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value); // Hash the password before saving
    // }

    /**
     * If you're also using a passkey, make sure to set it correctly
     * when registering or verifying it.
     */
    // public function setPasskeyAttribute($value)
    // {
    //     $this->attributes['passkey'] = $value; // Adjust if you need to hash the passkey
    // }
}
