<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsoinhospitaliser extends Model
{
    protected $fillable=['id','refHospitaliser','dateSoin','Temperature_hospi','TA_hospi',
    'Poils_hospi','Dieurese_hospi','Poids_hospi','Taille_hospi','FC_hospi','FR_hospi',
    'Oxygene_hospi','moment','author'];
    protected $table = 'tsoinhospitaliser';
}
