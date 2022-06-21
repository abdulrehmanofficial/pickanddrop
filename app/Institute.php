<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lat','long','driver_id'
    ];

    public function driver()
    {
        return $this->belongsTo('App\User','driver_id');
    }
}
