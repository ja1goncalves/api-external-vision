<?php

namespace App;

use App\AbstractModulesModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * Class User
 * @package App
 */
class User extends AbstractModulesModel
    implements \Illuminate\Contracts\Auth\Authenticatable,
               \Illuminate\Contracts\Auth\Access\Authorizable,
               \Illuminate\Contracts\Auth\CanResetPassword
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * @return string
     */
    public function newApiTokenAttribute()
    {
        return bcrypt($this->attributes['email']);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
    [
        'name',
        'email',
        'password',
        'active',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden =
    [
        'password',
        'remember_token'
    ];


    /**
     * Scopes
     */


    /**
     * Get Attributes
     */


    /**
     * Set Attributes
     */
}
