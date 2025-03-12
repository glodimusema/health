<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_bilan_hydrique extends Model
{

    protected $fillable=['id','refHospi','dateBilan','totalEntree','totalSortie',
    'hydrique','poids','author'];
    protected $table = 'thospi_bilan_hydrique';
}
