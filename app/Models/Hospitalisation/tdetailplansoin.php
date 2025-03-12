<?php

namespace App\Models\Hospitalisation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tdetailplansoin extends Model
{
    protected $fillable=['id','refPlanSoin','dateDetailPlan','heure','probleme',
    'Temperature_plan','PIS_plan','PA_plan','FC_plan','FR_plan','besoins_plan',
    'diagnostic_plan','objectif_plan','intervension_plan','evaluation_plan',
    'infirmier_plan','author'];
    protected $table = 'tdetailplansoin';
}
