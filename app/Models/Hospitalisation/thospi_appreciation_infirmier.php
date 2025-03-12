<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_appreciation_infirmier extends Model
{
    protected $fillable=['id','refHospi','degreSatisfaction','remarques','sugestion','infirmier'];
    protected $table = 'thospi_appreciation_infirmier';
}

