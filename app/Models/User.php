<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';

    protected $field = [
        'id' ,
        'account' ,
        'nick_name' ,
        'true_name',
        'mobile',
        'avatar',
        'email',
        'created_at',
        'sex',
        'wx_openid',
        'wx_unionid',
        'remember_token'
    ];

    protected $fillable = [
        'name', 'email', 'password',
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
