<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'USERID','PASSWORD','USERNAME','DESIGNATION','USER_AUTHORIZATION','LASTNAME','FIRSTNAME','MIDDLENAME','EMAIL',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'PASSWORD', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['PASSWORD'] = bcrypt($password);
    }
}
