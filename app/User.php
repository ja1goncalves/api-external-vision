<?php

namespace App;



 use Illuminate\Notifications\Notifiable;
 use Illuminate\Foundation\Auth\Authenticatable;
 use Laravel\Passport\HasApiTokens;
 use Illuminate\Auth\Passwords\CanResetPassword;
 use Illuminate\Foundation\Auth\Access\Authorizable;

 class User extends Authenticatable
 {
     use Authenticatable, Authorizable, CanResetPassword;

     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = [
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
     protected $hidden = [
         'password',
         'remember_token',
     ];
 }