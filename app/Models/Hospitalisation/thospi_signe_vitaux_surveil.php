<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_signe_vitaux_surveil extends Model
{
    protected $fillable=['id','refSurvHospi','heure','temperatureSurv','TA',
    'respiration','pulsation', 'qtepulsation','etatconscience','mouvement',
    'vomissement','qteVomissement','diarhee','qteDiarhee','drainGauche',
    'drainDroite','duirese','qteDuirese','perfusion','qtePerfusion','AborVeineux',
    'Glycemie','hemoragie','oxygene','pensement','detailPensement','observation','author'];
    protected $table = 'thospi_signe_vitaux_surveil';
}

