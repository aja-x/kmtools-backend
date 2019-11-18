<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userKmAttribute()
    {
        return $this->hasOne('App\UserKmAttribute', 'id_user');
    }

    public function article()
    {
        return $this->hasMany('App\Article', 'id_user');
    }

    public function errorReport()
    {
        return $this->hasMany('App\ErrorReport', 'id_user');
    }

    public function testHistory()
    {
        return $this->hasMany('App\TestHistory', 'id_user');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment', 'id_user');
    }
}
