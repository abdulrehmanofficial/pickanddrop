<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password','mobile','address','user_image','cnic_front','cnic_back','user_type','user_status'
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

    public function getUserImageAttribute($user_image)
    {
        return asset("uploads/".$user_image);
    }

    public function getCnicFrontAttribute($cnic_front)
    {
        return asset("uploads/".$cnic_front);
    }

    public function getCnicBackAttribute($cnic_back)
    {
        return asset("uploads/".$cnic_back);
    }

    public function vehicle()
    {
        return $this->hasOne('App\DriverData','user_id');
    }

    public function rating()
    {
        return $this->hasOne('App\Rating','driver_id');
    }
}
