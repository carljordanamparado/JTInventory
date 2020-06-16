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
     *
     */
    protected $primaryKey = 'id';
    protected $table = 'users';
    protected $guard = 'web';
    protected $fillable = [
        /*'USERID','PASSWORD','USERNAME','DESIGNATION','USER_AUTHORIZATION','LASTNAME','FIRSTNAME','MIDDLENAME','EMAIL',*/
        'userid','password','username','designation','user_authorization','lastname','firstname','middlename','email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       'password', 'remember_token',
    ];


}
