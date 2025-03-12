<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_diabetiquee_hospi extends Model
{
    protected $fillable=['id','refSurvHospi','dateDiab','glycemieMatin','doseMatin',
    'siteMatin','ObservationMatin','glycemieSoir','doseSoir','siteSoir','observationSoir'
    ,'author'];
    protected $table = 'thospi_diabetiquee_hospi';
}

