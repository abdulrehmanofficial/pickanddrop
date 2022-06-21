<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverData extends Model
{
    public function getLicenceImageAttribute($licence_image)
    {
        return asset("uploads/".$licence_image);
    }

    public function getCertificateImageAttribute($certificate_image)
    {
        return asset("uploads/".$certificate_image);
    }
}
