<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_observation_infirmier extends Model
{
    //id,refHospi,observation,author
    protected $fillable=['id','refHospi','observation','author'];
    protected $table = 'thospi_observation_infirmier';
}
