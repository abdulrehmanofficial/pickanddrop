<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public function driver()
    {
        return $this->belongsTo('App\User','driver_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function institute()
    {
        return $this->belongsTo('App\Institute','institute_id');
    }

    public function schedule()
    {
        return $this->hasOne('App\Schedule','driver_id');
    }

    public function rating()
    {
        return $this->hasOne('App\Rating','driver_id');
    }
}
