<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_detail_surveillance_plaie extends Model
{
    protected $fillable=['id','refSurvPlaie','dateSurv','surfaceCm','profondeurMin'
    ,'Pics','BVA','protocole','author'];
    protected $table = 'thospi_detail_surveillance_plaie';
}

