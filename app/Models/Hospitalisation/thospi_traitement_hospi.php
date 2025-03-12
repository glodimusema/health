<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_traitement_hospi extends Model
{
    protected $fillable=['id','refHospi','kine','alimentation','observation','author'];
    protected $table = 'thospi_traitement_hospi';
}
