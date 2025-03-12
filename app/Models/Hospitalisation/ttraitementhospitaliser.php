<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttraitementhospitaliser extends Model
{
    protected $fillable=['id','refHospitaliser','refMedeicament','dateTraitement','dose','quantite','voie','autreDetails','moment','author'];
    protected $table = 'ttraitementhospitaliser';
}
