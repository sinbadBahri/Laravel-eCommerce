<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Finance\Discount;
use App\Models\Finance\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    /**
     * The users table has a one to one relationship with the wallet table.
     */
    public function wallet()
    {

        return $this->hasOne(Wallet::class);
        
    }

    /**
     * Automatically creates a Wallet instance for the user whenever a User Model creates.
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $user->wallet()->create();
        });
    }

    /**
     * Define a many-to-many relationship with the Discount model.
     */
    public function discounts()
    {

        return $this->belongsToMany
        (
            related: Discount::class,
            table: 'discount_user_relations',
        );
        
    }

    /**
     * Defines a one-to-one relationship with the UserInformation model.
     */
    public function userInformation()
    {

        return $this->hasOne(UserInformation::class);
        
    }

}
