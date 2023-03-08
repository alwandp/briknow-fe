<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username', 'personal_number', 'password','is_admin','last_login_at','direktorat','divisi'
    ];

    protected $dates= [
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_log(){
        return $this->HasMany(user_log::class,'id');
    }

    public function favorite_consultant(){
        return $this->HasMany(favorite_consultant::class,'id');
    }

    public function favorite_project(){
        return $this->hasMany(favorite_project::class,'id');
    }
}