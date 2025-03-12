<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_acte_infirmier extends Model
{   
    protected $fillable=['id','refHospi','refActeMedical','Description','auther'];
    protected $table = 'thospi_acte_infirmier';
}



