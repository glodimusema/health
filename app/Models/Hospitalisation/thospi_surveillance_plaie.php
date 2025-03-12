<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_surveillance_plaie extends Model
{
    //
    protected $fillable=['id','refHospi','refTypePlaie','localisation','pourcentageNoire',
    'pourcentageMarron','pourcentageJaune','pourcentageRouge','pourcentageRose','author'];
    protected $table = 'thospi_surveillance_plaie';
}
