<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thospi_surveil_neonatologie extends Model
{
    protected $fillable=['id','refHospi','assistantMedical','dateSurvNeo','heure'
    ,'poidsSurvNeo','temperatureSurvNeo','FcSurvNeo','FrSurvNeo','SaOxygene'
    ,'Resme','v','s','u','photo','traitement','natureRepas','Repme','author'];
    protected $table = 'thospi_surveil_neonatologie';
}
